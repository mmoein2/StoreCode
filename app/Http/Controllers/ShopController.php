<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopCategory;
use App\SubCode;
use Illuminate\Http\Request;
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
        $shops=$shops->with('category')->latest()->paginate();
        return view('shop.index',compact('shops','shop_categories'));
    }
    public function create()
    {
        $shop_categories = ShopCategory::get();

        return view('shop.create',compact('shop_categories'));
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
        ]);

        $shop = new Shop($request->all());
        $shop->score=0;
        $shop->used_score=0;
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
        $codes = $codes->paginate();
        return view('shop.show',compact('shop','codes'));
    }

    public function modifyCategory(Request $request)
    {
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
}
