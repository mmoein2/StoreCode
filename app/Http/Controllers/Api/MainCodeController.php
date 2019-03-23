<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\MainCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MainCodeController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);

        $current_timestamp = Carbon::now()->isoFormat('x');

        DB::beginTransaction();
        $maincode = MainCode::with('prize')->where('code',$request->code)
            ->where('status',false)->where('customer_id',null)
            ->where('expiration_date','>=',$current_timestamp)->first();

        if($maincode==null)
        {
            return[
                'status_code'=>1,
                'message'=>'کد وارد شده در سیستم پیدا نشد'
            ];
        }
        $customer = auth()->user();
        if($customer->status==false)
        {
            return [
                'status_code'=>'1',
                'message' =>'خدمات سایت برای شما غیر فعال شده است'
            ];
        }

        if($customer->score<$maincode->score)
        {
            return [
                'status_code'=>'2',
                'message' =>'امتیاز شما کافی نیست'
            ];
        }
        $maincode->customer_date=$current_timestamp;
        $maincode->status=true;
        $maincode->customer_id=$customer->id;
        $maincode->prize_name = $maincode->prize->name;

        $customer->used_score += $maincode->score;
        $customer->score  -= $maincode->score;

        $customer->save();
        $maincode->save();

        DB::commit();

        return [
            'status_code' => 0
        ];

    }
}
