<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Customer;
use App\CustomerShop;
use App\CustomerSupport;
use App\Post;
use App\Province;
use App\Shop;
use App\ShopCategory;
use App\SubCode;
use Carbon\Carbon;
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
        $id = auth()->id();

        $shops = Shop::with(['category','province','city']);

        if($request->isFollowed)
        {
            $flag = $request->isFollowed;

            if($flag==1)
            {
                $array = CustomerShop::where('customer_id',$id)->select(['shop_id']);
                $shops = $shops->whereIn('id',$array);
            }
            elseif($flag==2)
            {
                $array = CustomerShop::where('customer_id',$id)->select(['shop_id']);
                $shops = $shops->whereNotIn('id',$array);
            }
        }
        if($request->category_name)
        {
            $shops = $shops->whereHas('category',function ($q)use($request){
                $q->where('name','like','%'.$request->category_name.'%');
            });
        }
        if($request->city_id)
        {
            $shops = $shops->where('city_id',$request->city_id);
        }
        if($request->shop_category_id)
        {
            $shops = $shops->where('shop_category_id',$request->shop_category_id);
        }
        if($request->text)
        {
            $text = $request->text;
            $search_command = $request->search_command;
            if($search_command)
            {

                if($search_command==1)
                {
                    $shops = $shops->where('name','like','%'.$text.'%');

                }
                elseif($search_command==2)
                {
                    $shops = $shops->where('desc','like','%'.$text.'%');
                }
                elseif($search_command==3)
                {
                    $shops = $shops->where('desc','like','%'.$text.'%')
                    ->orWhere('name','like','%'.$text.'%');
                }
            }

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
            'thumbnail'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:2048',

        ]);
        if($request->exists('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $url = '/upload/customers';
            $name = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($url),$name);
            $customer->thumbnail=$url.'/'.$name;
        }
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
        if($request->date_of_birth)
        {
            $customer->date_of_birth= $request->date_of_birth;

        }
        if($request->email)
        {
            $customer->email= $request->email;

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
    public function shopCategory(Request $request){
        $categories = ShopCategory::get();
        return [
            'message'=>'0',
            'data'=>$categories
        ];
    }

    public function register(Request $request)
    {
        $request->validate([
            'mobile'=>'required|min:11|max:11|unique:customers',
            'fullname'=>'required|max:50',
            'isMan'=>'required|integer|min:0|max:1',
            'city_id'=>'required|integer|min:1'
        ]);
        $customer = new Customer();
        $customer->score=0;
        $customer->fullname=$request->fullname;
        $customer->mobile=$request->mobile;
        $customer->used_score=0;
        $customer->registration_date=Carbon::now()->isoFormat('x');
        $customer->isMan=$request->isMan;
        $customer->status=1;
        $customer->city_id=$request->city_id;
        $customer->province_id = City::find($request->city_id)->province->id;
        $customer->card_count = 0;

        $customer->save();

        return['message'=>'0'];
    }

}
