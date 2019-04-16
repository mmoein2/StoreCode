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
            ->where('status',false)->where('customer_id',null)->first();
        //    ->where('expiration_date','>=',$current_timestamp)->first();

        if($maincode==null)
        {
            return[
                'message'=>'کد وارد شده در سیستم پیدا نشد'
            ];
        }
        $customer = auth()->user();
        if($customer->status==false)
        {
            return [
                'message' =>'خدمات سایت برای شما غیر فعال شده است'
            ];
        }

        if($customer->score-$customer->used_score  <  $maincode->prize->score)
        {
            return [
                'message' =>'امتیاز شما کافی نیست'
            ];
        }
        $maincode->customer_date=$current_timestamp;
        $maincode->status=true;
        $maincode->customer_id=$customer->id;
        $maincode->prize_name = $maincode->prize->name;
        $maincode->score= $maincode->prize->score;
        $maincode->expiration_date = Carbon::now()->addDays($maincode->expiration_day)->isoFormat('x');

        $customer->used_score += $maincode->score;

        $customer->save();
        $maincode->save();

        DB::commit();

        return [
            'message'=>'0'
        ];

    }
    public function all(Request $request)
    {
        $query = MainCode::with('prize');
        $query = $query->where('status',false);

        if($request->prize_id)
        {
            $query=$query->where('prize_id',$request->prize_id);
        }


        $query=$query->orderByDesc('id')->select([
            'code',
            'prize_id',
            'expiration_day',
        ])->paginate();

        return [
            'message'=>'0',
            'data'=>$query
        ];

    }
    public function index(Request $request)
    {
        $customer = auth()->user();
        $query = MainCode::query();
        $query = $query->where('status',true);
        $query=$query->where('customer_id',$customer->id);

        if($request->prize_id)
        {
            $query=$query->where('prize_id',$request->prize_id);
        }

        if($request->date_from)
        {
            $query=$query->where('customer_date','>=',$request->date_from);

        }
        if($request->date_to)
        {
            $query=$query->where('customer_date','<=',$request->date_to);

        }
        if($request->score)
        {
            $query=$query->where('score',$request->score);

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
            'message'=>'0',
            'data'=>$query
        ];
    }
    public function getPrizeCategory()
    {
        $prizes = Prize::get();
        return[
            'message'=>'0',
            'data' => $prizes
        ];
    }
}
