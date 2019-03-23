<?php

namespace App\Http\Controllers\Api;

use App\CustomerShop;
use App\Post;
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
}
