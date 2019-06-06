<?php

namespace App\Http\Controllers;

use App\City;
use App\ConfirmShop;
use App\Province;
use App\Shop;
use App\ShopCategory;
use App\SubCode;
use App\Utility\FireBase;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Morilog\Jalali\Jalalian;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::query();
        $shop_categories = ShopCategory::get();
        if($request->category_id)
        {
            $shops=$shops=$shops->where('shop_category_id',$request->category_id);
        }
        if($request->id)
        {
            $shops= $shops->where('id',$request->id);
        }
        if($request->name)
        {
            $shops=$shops->where('name','like','%'.$request->name.'%');
        }
        if($request->mobile)
        {
            $shops=$shops->where('mobile',$request->mobile);
        }
        if($request->scoreFrom)
        {
            $shops= $shops->where('score','>=',$request->scoreFrom);
        }
        if($request->scoreTo)
        {
            $shops=$shops->where('score','<=',$request->scoreTo);
        }
        if($request->usedscoreFrom)
        {
            $shops=  $shops->where('used_score','>=',$request->usedscoreFrom);
        }
        if($request->usedscoreTo)
        {
            $shops=$shops->where('used_score','<=',$request->usedscoreTo);
        }
        $shops=$shops->orderBy($request->sort_field??'created_at',$request->sort??'asc');
        if($request->command)
        {
            if(auth()->user()->email!='admin')
                return back()->withErrors(['دسترسی غیر مجاز']);
            $message = ($request->message);
            if($request->command=="message")
            {
                $shops=$shops->pluck('mobile');
                $res = Smsirlaravel::send($message,$shops->toArray());
                if($res['IsSuccessful']==true)
                    return back()->with(['message'=>'پیام با موفقیت ارسال شد']);
                else
                    return back()->withErrors([$res['Message']]);
            }
            elseif($request->command=="notification")
            {
                $shops = $shops->where('play_id','!=',null);
                $shops = $shops->pluck('play_id');

                $firebase = new FireBase();

                foreach ($shops as $c)
                {
                    $firebase->send($c,$message);
                }
                return back()->with(['message'=>'نوتیفیکیشن ارسال شد']);

            }
        }
        $shops = $shops->with(['category','province','city'])->paginate();
        return view('shop.index',compact('shops','shop_categories'));
    }
    public function create(Request $request)
    {
        $shop_categories = ShopCategory::get();
        $provinces = Province::get();
        $cities=[];
        if($request->province_id)
        {
            $cities = City::where('province_id',$request->province_id)->get();
        }
        return view('shop.create',compact('shop_categories','provinces','cities'))->with($request->all());
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'shop_category_id' => 'required|numeric',
            'mobile' => 'required|numeric',
            'phone' => 'required|numeric',
            'person' => 'required',
            'address' => 'required',
            'city_id' => 'required',
        ]);

        $shop = new Shop($request->all());
        $shop->password= substr(md5(uniqid(rand(), true)),0,4);
        $shop->score=0;
        $shop->used_score=0;
        $shop->followers=0;

        $city = City::find($request->city_id);
        if($city==null)
        {
            return back()->withInput($request->all())->withErrors(['شهر را انتخاب کنید']);
        }
        $shop->province_id=$city->province_id;
        $shop->save();
        return redirect('/shop');

    }
    public  function show(Request $request)
    {
        $shop = Shop::find($request->id);
        $codes = SubCode::where('shop_id',$shop->id);

        if($request->code)
        {
            $codes=$codes->where('code',$request->code);
        }
        if($request->serialFrom)
        {
            $codes=$codes->where('serial','>=',$request->serialFrom);
        }
        if($request->serialTo)
        {
            $codes=$codes->where('serial','<=',$request->serialTo);
        }
        if($request->scoreFrom)
        {
            $codes=$codes->where('score','>=',$request->scoreFrom);
        }
        if($request->scoreTo)
        {
            $codes=$codes->where('score','<=',$request->scoreTo);
        }
        if($request->status)
        {
            $s=$request->status;
            if($s==-1)
                $codes=$codes->where('status',0);
            else if ($s==1)
                $codes=$codes->where('status',1);
            else if ($s==2)
                $codes=$codes->where('status',2);

        }
        if($request->shopDateFrom)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->shopDateFrom.' 00:00:00')->getTimestamp()*1000;
            $codes=$codes->where('shop_date','>=',$ts);


        }
        if($request->shopDateTo)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->shopDateTo.' 23:59:59')->getTimestamp()*1000;
            $codes=$codes->where('shop_date','<=',$ts);
        }
        $codes = $codes->orderBy($request->sort_field??'id',$request->sort??'asc')->paginate();
        return view('shop.show',compact('shop','codes'));
    }

    public function modifyCategory(Request $request)
    {
        $request->validate(['command'=>'required','name'=>'required']);
        $command = $request->command;
        if($command=='register')
        {
            $c = new ShopCategory();
            $c->name=$request->name;
            $c->save();

        }
        elseif($command=='delete')
        {
            $d = ShopCategory::where('name',$request->name)->first();
            try {
                $d->delete();
            }
            catch(\Exception $ex) {
                return back()->withErrors(['حذف مقدور نیست']);
            }
        }
        return back();

    }
    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            ConfirmShop::where('shop_id',$request->id)->delete();
            Shop::destroy($request->id);
            DB::commit();
        }
        catch (\Exception $exception)
        {
            return back()->withErrors(['امکان حذف وجود ندارد']);
        }
        return back();
    }
    public function edit(Request $request)
    {
        $shop_categories = ShopCategory::get();
        $provinces = Province::get();
        $shop = Shop::find($request->id);

        $cities=null;
        if($request->province_id)
        {
            $cities = City::where('province_id',$request->province_id)->get();
        }
        else
        {
            $cities = City::where('province_id',$shop->province_id)->get();
        }
        return view('shop.edit',compact('shop','shop_categories','provinces','cities'));

    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'shop_category_id' => 'required|numeric',
            'mobile' => 'required|numeric',
            'phone' => 'required|numeric',
            'person' => 'required',
            'address' => 'required',
            'city_id' => 'required',
        ]);
        $shop = Shop::find($request->id);
        $city = City::find($request->city_id);
        if($city==null)
        {
            return back()->withInput($request->all())->withErrors(['شهر را انتخاب کنید']);
        }
        $shop->shop_category_id=$request->shop_category_id;
        $shop->name=$request->name;
        $shop->mobile=$request->mobile;
        $shop->phone=$request->phone;
        $shop->person=$request->person;
        $shop->address=$request->address;
        $shop->city_id=$city->id;
        $shop->province_id=$city->province_id;


        $shop->save();
        return redirect('/shop');

    }
    public function detail(Request $request)
    {
        $shop = Shop::find($request->id);
        return view('shop.detail',compact('shop'));

    }
    public function passwordSms(Request $request)
    {
        $shop = Shop::find($request->id);
        $res = Smsirlaravel::send('رمز عبور شما : '.$shop->password,[$shop->mobile]);
        //dd($res);
        if($res['IsSuccessful']==true)
            return back()->with(['message'=>'رمز عبور با موفقیت ارسال شد']);
        else
            return back()->withErrors([$res['Message']]);

    }
}
