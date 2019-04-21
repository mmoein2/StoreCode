<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\CustomerShop;
use App\SubCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class SubCodeController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'from'=>'required',
            'text'=>'required',
        ]);
        $isFirstTime=false;

        $current_timestamp = Carbon::now()->isoFormat('x');

        DB::beginTransaction();
        $subcode = SubCode::with('shop')->where('code',$request->text)
            ->where('status',1)->where('customer_id',null)
            ->where('expiration_date','>=',$current_timestamp)->first();

        if($subcode==null)
        {
            return[
                'message'=>'کد وارد شده در سیستم پیدا نشد'
            ];
        }
        $shop = $subcode->shop;


        $customer = Customer::where('mobile',$request->from)->first();

        if($customer==null)
        {
            $isFirstTime=true;
            $customer = new Customer();
            $customer->mobile=$request->from;
            $customer->score=0;
            $customer->used_score=0;
            $customer->registration_date=$current_timestamp;
            $customer->status=true;
            $customer->save();
        }
        if($customer->status==false)
        {
            return [
                'message' =>'خدمات سایت برای شما غیر فعال شده است'
            ];
        }
        $customer->score+=$subcode->score;
        $shop->used_score+=$subcode->score;

        $subcode->status=2;
        $subcode->customer_id=$customer->id;
        $subcode->customer_date=$current_timestamp;

        //customer didn't follow the shop
        if(!CustomerShop::where('shop_id',$shop->id)->where('customer_id',$customer->id)->exists())
        {
           $cs = new CustomerShop();
           $cs->customer_id = $customer->id;
           $cs->shop_id= $shop->id;

        }

        $customer->save();
        $subcode->save();
        $shop->save();

        if(isset($cs))
            $cs->save();

        DB::commit();

        if($isFirstTime)
        {
            Smsirlaravel::send('تبریک! شما عضو سیستم شدید. امتیاز فعلی شما '.$customer->score,[$customer->mobile]);
        }

        return [
            'message'=>'0'
        ];

    }
}
