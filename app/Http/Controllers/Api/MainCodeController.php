<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\MainCode;
use App\Prize;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            ->where('status',false)->where('customer_id',null);
        //    ->where('expiration_date','>=',$current_timestamp)->first();

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

        if($customer->score-$customer->used_score  <  $maincode->prize->score)
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
        $maincode->score= $maincode->prize->score;

        $customer->used_score += $maincode->score;

        $customer->save();
        $maincode->save();

        DB::commit();

        return [
            'status_code' => 0
        ];

    }
    public function all(Request $request)
    {
        $customer = auth()->user();
        $query = MainCode::with('prize');
        $query = $query->where('status',false);

        $query=$query->orderByDesc('id')->select([
            'code',
            'score',
            'expiration_date',
            'prize_id'
        ])->paginate();

        return [
            'status_code'=>0,
            'data'=>$query
        ];

    }
    public function index(Request $request)
    {
        $customer = auth()->user();
        $query = MainCode::with('prize');
        $query = $query->where('status',true);
        $query=$query->where('customer_id',$customer->id);

        if($request->prize_id)
        {
            $query=$query->where('prize_id',$request->prize_id);
        }

        $query=$query->orderByDesc('id')->select([
            'id',
            'code',
            'score',
            'customer_date',
            'expiration_date',
            'prize_name',
        ])->paginate();
        return [
            'status_code'=>0,
            'data'=>$query
        ];
    }
    public function getPrizeCategory()
    {
        $prizes = Prize::get();
        return[
            'status_code'=>0,
            'data' => $prizes
        ];
    }
}
