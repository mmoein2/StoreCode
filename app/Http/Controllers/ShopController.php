<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopCategory;
use Illuminate\Http\Request;

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
    public function store()
    {

    }
}
