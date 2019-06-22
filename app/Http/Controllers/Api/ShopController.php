<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Customer;
use App\Discount;
use App\DiscountMember;
use App\Message;
use App\NotiOrMessage;
use App\NotiOrMessageMember;
use App\Shop;
use App\SubCode;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class ShopController extends Controller
{
    public function getSubCodes(Request $request)
    {
        $shop = auth()->user();
        $query = SubCode::where('shop_id',$shop->id);

        if($request->code)
        {
            $query=$query->where('code',$request->code);
        }

        if($request->serialFrom)
        {
            $query=$query->where('serial','>=',$request->serialFrom);
        }
        if($request->serialTo)
        {
            $query=$query->where('serial','<=',$request->serialTo);
        }

        if($request->status)
        {
            $s=$request->status;
            if ($s==1)
                $query=$query->where('status',1);
            else if ($s==2)
                $query=$query->where('status',2);

        }
        if($request->dateFrom)
        {
            $query=$query->where('expiration_date','>=',$request->dateFrom);

        }
        if($request->dateTo)
        {
            $query=$query->where('expiration_date','<=',$request->dateTo);
        }

        $query=$query->orderByDesc('id')->paginate();
        return [
            'message'=>'0',
            'data'=>$query
        ];
    }
    public function storeMessage(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'text'=>'required',
        ]);

        $title = $request->title;
        $text = $request->text;

        $message = new Message();
        $message->title = $title;
        $message->text = $text;
        $message->shop_id = auth()->id();
        $message->isMessage=0;

        $message->save();
        return [
            'message'=>'0',
        ];
    }
    public function updateProfile(Request $request)
    {
        $store  = auth()->user();
        $request->validate([
            'thumbnail'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:2048',

        ]);
        if($request->exists('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $url = '/upload/shops';
            $name = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($url),$name);
            $store->thumbnail=$url.'/'.$name;
        }
        if($request->desc)
        {
            $store->desc = $request->desc;
        }
        if($request->lat)
        {
            $store->lat = $request->lat;
        }
        if($request->lng)
        {
            $store->lng= $request->lng;
        }
        if($request->time)
        {
            $store->time= $request->time;
        }
        if($request->address)
        {
            $store->address= $request->address;
        }
        if($request->phone)
        {
            $store->address= $request->phone;
        }

        $store->save();
        return['message'=>'0'];
    }
    public function updateImages(Request $request)
    {
        $shop  = auth()->user();
        $request->validate([
            'image1'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image2'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image3'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image4'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image5'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image6'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image7'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image8'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image9'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image10'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image11'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image12'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'thumbnail'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:2048',
        ]);
        if($request->exists('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $url = '/upload/shops';
            $name = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($url),$name);
            $shop->thumbnail=$url.'/'.$name;
        }


            $images= [];
        if($shop->images)
            $images=$shop->images;
        for($i=1;$i<=12;$i++)
        {
            if($request->exists('image'.$i))
            {

            $file = $request->file('image'.$i);
            $url = '/upload/shops';
            $name = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($url),$name);
            if(isset($images[$i]))
            {
                \Illuminate\Support\Facades\File::delete(public_path($images[$i]));
            }
            $images[$i]=$url.'/'.$name;

            }

        }
        $shop->images = $images;
        $shop->save();
        return['message'=>'0'];
    }
    public function customers(Request $request)
    {
        $shop_id = auth()->id();

        $customers_id = SubCode::where('shop_id',$shop_id)->where('customer_id','!=',null)->select(['customer_id']);
        $customers = Customer::whereIn('id',$customers_id);
        if($request->scoreFrom)
        {
            $customers = $customers->where(DB::raw('score-used_score'),'>=',$request->scoreFrom);
        }
        if($request->scoreTo)
        {
            $customers = $customers->where(DB::raw('score-used_score'),'<=',$request->scoreTo);

        }
        if($request->card)
        {
            $data = SubCode::where('score',$request->card)->select('customer_id');
            $customers=$customers->whereIn('id',$data);
        }
        if($request->city_id)
        {
            $customers=$customers->where('city_id',$request->city_id);
        }
        if($request->id)
        {
            $customers=$customers->where('id',$request->id);
        }
        if($request->date_from)
        {
            $customers=$customers->whereHas('latestSubCode',function ($q)use ($request){
                $q->where('customer_date','>=',$request->date_from);
            });

        }
        if($request->date_to)
        {
            $customers=$customers->whereHas('latestSubCode',function ($q)use ($request){
                $q->where('customer_date','<=',$request->date_to);
            });

        }

        $data_count = $customers->count();


        $customers = $customers->with('latestSubCode')->paginate();

        return[
            'message'=>'0',
            'data'=>$customers,
            'customer_count'=>$data_count
        ];

    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|max:30',
            'shop_category_id'=>'required|integer|min:1',
            'mobile'=>'required|min:11|max:11|unique:shops',
            'phone'=>'required|min:7',
            'address'=>'required|min:7',
            'person'=>'required',
            'city_id'=>'required|integer|min:1',
        ]);
        $shop = new Shop();
        $shop->name = $request->name;
        $shop->shop_category_id = $request->shop_category_id;
        $shop->mobile = $request->mobile;
        $shop->phone = $request->phone;
        $shop->address = $request->address;
        $shop->person = $request->person;
        $shop->city_id = $request->city_id;
        $shop->province_id = City::find($request->city_id)->province->id;
        $shop->password= substr(md5(uniqid(rand(), true)),0,4);

        $shop->score=0;
        $shop->used_score=0;
        $shop->followers=0;
        $shop->save();
        Smsirlaravel::send('رمز شما جهت ورود :'.$shop->password,$shop->mobile);

        return['message'=>'0'];

    }
    public function getSubcodeVariaty(){
        $bar_lables = SubCode::groupBy('score')->select('score')->orderBy('score','asc')->get()->pluck('score');
        return [
            'message'=>'0',
            'data'=>$bar_lables
        ];

    }

    public function registerDiscount(Request $request)
    {
        $shop = auth()->user();
        $request->validate([
            'type'=>'required|max:2|min:1|integer',
            'discount'=>'required|integer|min:1',
            'expiration_date'=>'required|integer|min:1',

        ]);
        DB::beginTransaction();

        $type = $request->type;
        $expiration_date = $request->expiration_date;
        $discount = $request->discount;
        //based on checked customers
        if($type==1)
        {
            $request->validate([
                'customers'=>'required',
            ]);
            $array = explode(',',($request->customers));
            $d = new Discount();
            $d->shop_id= $shop->id;
            $d->discount= $discount;
            $d->expiration_date = $expiration_date;
            $d->save();
            foreach ($array as $item)
            {
                $dm = new DiscountMember();
                $dm->customer_id = $item;
                if(!Customer::where('id',$item)->exists())
                {
                    return [
                        'message'=>'مشتری با کد انتخابی '.$item.' وجود ندارد '
                    ];
                }
                $dm->discount_id =  $d->id;

                $dm->save();
            }

        }
        //based on query
        elseif($type==2)
        {
            $request->validate([
                'qty'=>'required|integer|min:1',
                'city_id'=>'sometimes|required|integer|min:1',
                'province_id'=>'required|integer|min:1',

            ]);

            $qty = $request->qty;
            $city_id = $request->city_id;
            $province_id = $request->province_id;

            $customers = Customer::where('province_id',$province_id);
            if($request->city_id)
            {
                $customers = $customers->where('city_id',$city_id);
            }
            $d = new Discount();
            $d->shop_id= $shop->id;
            $d->discount= $discount;
            $d->expiration_date = $expiration_date;

            $d->save();
            $customers=$customers->latest()->take($qty)->get();
            $ct=0;
            foreach ($customers as $customer)
            {
                $ct++;
                $dm = new DiscountMember();
                $dm->customer_id = $customer->id;
                $dm->discount_id =  $d->id;

                $dm->save();
            }
            if($ct==0)
            {
                return[
                    'message'=>'هیچ شخصی با این مشخصات وجود ندارد'
                ];
            }



        }
        DB::commit();

        return ['message'=>'0'];
    }
    public function historyDiscount(Request $request)
    {
        $shop = auth()->user();

        $res = Discount::where('shop_id',$shop->id)->orderByDesc('id')->paginate();
        return[
            'message'=>'0',
            'data'=>$res
        ];

    }
    public function discountBurned(Request $request)
    {
        $shop = auth()->user();

        $request->validate([
            'customer_id'=>'required'
        ]);
        $customer_id = $request->customer_id;

        $dm = DiscountMember::where('customer_id',$customer_id)->latest()->first();
        if($dm==null)
        {
            return['message'=>'چنین کد تخفیفی صادر نشده است'];
        }
        if($dm->is_burned==true)
        {
            return['message'=>'کد تخفیف قبلا استفاده شده است'];
        }
        $d = $dm->discount;
        if($d->expiration_date<Carbon::now()->timestamp*1000)
        {
            return['message'=>'تاریخ انقضا گذشته است'];
        }
        if($d->shop_id!=$shop->id)
        {
            return['message'=>'کد تخفیف مربوط به فروشگاه دیگری است'];
        }
        $dm->is_burned=true;
        $dm->save();
        return[
            'message'=>'0'
        ];

    }

    public function registerMessage(Request $request)
    {
        $shop = auth()->user();
        $request->validate([
            'type1'=>'required|max:2|min:1|integer',//checked or no
            'type2'=>'required|max:2|min:1|integer',
            'text'=>'required',

        ]);
        DB::beginTransaction();

        $type1 = $request->type1;

        //1->noti,2=>message
        $type2 = $request->type2;
        $text = $request->text;

        $d = new NotiOrMessage();
        $d->type = $type2;
        $d->text= $text;
        $d->status= 0;
        $d->save();

        //checked
        if($type1==1) {
            $array = explode(',', ($request->customers));
            foreach ($array as $item) {
                $dm = new NotiOrMessageMember();
                $dm->customer_id = $item;
                if (!Customer::where('id', $item)->exists()) {
                    return [
                        'message' => 'مشتری با کد انتخابی ' . $item . ' وجود ندارد '
                    ];
                }
                $dm->noti_or_message_id = $d->id;

                $dm->save();
            }
        }
        elseif ($type1==2)
        {
            $request->validate([
                'qty'=>'required|integer|min:1',
                'city_id'=>'sometimes|required|integer|min:1',
                'province_id'=>'required|integer|min:1',

            ]);
            $qty = $request->qty;
            $city_id = $request->city_id;
            $province_id = $request->province_id;

            $customers = Customer::where('province_id',$province_id);
            if($request->city_id)
            {
                $customers = $customers->where('city_id',$city_id);
            }


            $customers=$customers->latest()->take($qty)->get();
            $ct=0;
            foreach ($customers as $customer)
            {
                $ct++;
                $dm = new NotiOrMessageMember();
                $dm->customer_id = $customer->id;
                $dm->noti_or_message_id =  $d->id;

                $dm->save();
            }
            if($ct==0)
            {
                return[
                    'message'=>'هیچ شخصی با این مشخصات وجود ندارد'
                ];
            }
            if($ct<=50)
            {
                $d->status=1;
                $d->save();
            }
        }

           DB::commit();

        return ['message'=>'0','noti_message_id'=>$d->id];
    }

}
