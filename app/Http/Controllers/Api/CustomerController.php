<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\CustomerShop;
use App\Post;
use App\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function showPosts(Request $request)
    {
        $customer = auth()->user();

        $shops = CustomerShop::where('customer_id',$customer->id)->select(['shop_id']);

        $post = Post::with('shop')->whereIn('shop_id',$shops)->latest()->paginate();

        return[
            'status_code'=>0,
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
                'status_code'=>1,
                'message'=>'شما در حال دنبال کردن این فروشگاه هستید'
            ];

        }
        $cs = new CustomerShop();
        $cs->customer_id=$customer->id;
        $cs->shop_id=$request->shop_id;
        $cs->save();

        return [
            'status_code'=>0
        ];
    }
    public function shops(Request $request)
    {
        $shops = Shop::with('category');
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
        $shops=$shops->select(['name','person','desc','city','shop_category_id'])->latest()->paginate();
        return[
            'status_code'=>0,
            'data'=>$shops
        ];

    }
}
