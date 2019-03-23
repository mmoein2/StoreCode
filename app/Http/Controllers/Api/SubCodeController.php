<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\SubCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SubCodeController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'code'=>'required',
            'mobile'=>'required',
        ]);
        $current_timestamp = Carbon::now()->isoFormat('x');

        DB::beginTransaction();
        $subcode = SubCode::where('code',$request->code)
            ->where('status',1)->where('customer_id',null)
            ->where('expiration_date','>=',$current_timestamp)->first();

        if($subcode==null)
        {
            return[
                'status_code'=>1,
                'message'=>'کد وارد شده در سیستم پیدا نشد'
            ];
        }
        $customer = Customer::where('mobile',$request->mobile)->first();
        if($customer->status==false)
        {
            return [
                'status_code'=>'1',
                'message' =>'خدمات سایت برای شما غیر فعال شده است'
            ];
        }
        if($customer==null)
        {
            $customer = new Customer();
            $customer->mobile=$request->mobile;
            $customer->score=0;
            $customer->used_score=0;
            $customer->registration_date=$current_timestamp;
            $customer->save();
            //send sms
        }

        $customer->score+=$subcode->score;

        $subcode->status=2;
        $subcode->customer_id=$customer->id;
        $subcode->customer_date=$current_timestamp;

        $customer->save();
        $subcode->save();

        DB::commit();

        return [
            'status_code' => 0
        ];

    }
}
