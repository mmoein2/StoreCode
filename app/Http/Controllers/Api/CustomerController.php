<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Customer;
use App\CustomerShop;
use App\CustomerSupport;
use App\Post;
use App\Province;
use App\Shop;
use App\SubCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function showPosts(Request $request)
    {
        $customer = auth()->user();

        $shops = CustomerShop::where('customer_id',$customer->id)->select(['shop_id']);

        $post = Post::with('shop')->whereIn('shop_id',$shops)->orWhere('is_special',true)->latest()->paginate();

        return[
            'message'=>'0',
            'data'=>$post
        ];

    }
    public function follow(Request $request)
    {
        $request->validate([
            'shop_id'=>'required|numeric'
        ]);

        $customer = auth()->user();
        if(CustomerShop::where('shop_id',$request->shop_id)->where('customer_id',$customer->id)->exists())
        {
            return [
                'message'=>'شما در حال دنبال کردن این فروشگاه هستید'
            ];

        }
        DB::beginTransaction();

        $cs = new CustomerShop();
        $cs->customer_id=$customer->id;
        $cs->shop_id=$request->shop_id;

        $shop = Shop::find($request->shop_id);
        $shop->followers++;
        $shop->save();

        $cs->save();

        DB::commit();

        return [
            'message'=>'0',
        ];
    }
    public function unFollow(Request $request)
    {
        $request->validate([
            'shop_id'=>'required|numeric'
        ]);

        $customer = auth()->user();
        $cs = CustomerShop::where('shop_id',$request->shop_id)->where('customer_id',$customer->id)->first();
        if($cs==null)
        {
            return [
                'message'=>'شما این فروشگاه را دنبال نمی کنید'
            ];

        }
        DB::beginTransaction();

        $shop = Shop::find($request->shop_id);
        $shop->followers--;
        $shop->save();

        $cs->delete();

        DB::commit();

        return [
            'message'=>'0',
        ];
    }
    public function shops(Request $request)
    {
        $shops = Shop::with(['category','province','city']);
        if($request->category_name)
        {
            $shops = $shops->whereHas('category',function ($q)use($request){
                $q->where('name','like','%'.$request->category_name.'%');
            });
        }
        if($request->city)
        {
            $shops = $shops->where('city','like','%'.$request->city.'%');
        }
        $shops=$shops->select(['id','name','person','desc','shop_category_id','address','lat','lng','images','followers','city_id','province_id']);
        if($request->id)
        {
            $shops = $shops->where('id',$request->id);
            $shops=$shops->get();

        }
        else
        {
            $shops=$shops->latest()->paginate();

        }
        return[
            'message'=>'0',
            'data'=>$shops
        ];

    }

    public function getSubCodes(Request $request)
    {
        $customer = auth()->user();
        $query = SubCode::with('shop_customer')->where('customer_id',$customer->id);

        if($request->code)
        {
            $query=$query->where('code',$request->code);
        }
        if($request->shop_name)
        {
            $query=$query->whereHas('shop',function ($q)use($request){
                $q->where('name','like','%'.$request->shop_name.'%');
            });
        }
        if($request->scoreFrom)
        {
            $query=$query->where('score','>=',$request->scoreFrom);

        }
        if($request->scoreTo)
        {
            $query=$query->where('score','<=',$request->scoreTo);
        }

        if($request->customerDateFrom)
        {
            $query=$query->where('customer_date','>=',$request->customerDateFrom);

        }
        if($request->customerDateTo)
        {
            $query=$query->where('customer_date','<=',$request->customerDateTo);
        }

        $query=$query->orderByDesc('id')->select([
            'id',
            'code',
            'score',
            'shop_id',
            'customer_date',
        ])
            ->paginate();
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

        $message = new CustomerSupport();
        $message->title = $title;
        $message->text = $text;
        $message->customer_id= auth()->id();
        $message->status=false;

        $message->save();
        return [
            'message'=>'0',
        ];
    }

    public function updateProfile(Request $request)
    {
        $customer  = auth()->user();
        $request->validate([
            'national_code'=>'sometimes|numeric|digits:10',
            'city_id'=>'sometimes|numeric',
        ]);
        if($request->fullname)
        {
            $customer->fullname = $request->fullname;
        }
        if($request->city)
        {
            $customer->city = $request->city;
        }
        //1->man -1->woman
        if($request->IsMan)
        {
            if($request->IsMan==1)
                $customer->IsMan= true;
            elseif($request->IsMan==-1)
                $customer->IsMan= false;

        }
        if($request->national_code)
        {
            $customer->national_code= $request->national_code;

        }
        if($request->city_id)
        {
            $city = City::find($request->city_id);
            if($city==null)
            {
             return ['message'=>'شهر نا معتبر است'];
            }
            $customer->province_id=$city->province_id;
            $customer->city_id=$city->id;

        }

        $customer->save();
        return['message'=>'0'];
    }

    public function getProvince()
    {
        $provinces = Province::get();
        return [
            'message'=>'0',
            'data'=>$provinces
        ];
    }

    public function getCity(Request $request)
    {
        $request->validate([
            'province_id'=>'required|numeric'
        ]);

        $cities = City::where('province_id',$request->province_id)->select(['id','province_id','name'])->get();

        return [
            'message'=>'0',
            'data'=>$cities
        ];
    }

}
