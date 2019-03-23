<?php

namespace App\Http\Controllers;

use App\Shop;
use App\SubCode;
use Carbon\Carbon;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignSubCodeController extends Controller
{
    public function index()
    {
        return view('assign.index');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
            'serialFrom' =>"required|numeric",
            'serialTo' =>"required|numeric",
            'shop_id' =>"required|numeric",
        ]);
        //if(SubCode::where('serial','>=',$request->serialFrom)->where('serial','<=',$request->serialTo)->where('status','!=',0)->exists())
       // {
       //     return back()->withErrors(['محدوده سریال انتخابی قبلا استفاده شده است']);
       // }

        $shop_id = $request->shop_id;
        $shop = Shop::find($shop_id);

        SubCode::where('serial','>=',$request->serialFrom)->where('serial','<=',$request->serialTo)->where('status',0)
            ->chunk(100,function ($data) use ($shop_id,$shop){
                $sum=0;

                foreach ($data as $datum)
                {
                    $datum->shop_id=$shop_id;
                    $datum->status=1;
                    $datum->shop_date = Carbon::now()->isoFormat('x');
                    $datum->expiration_date = Carbon::now()->addDays($datum->expiration_day)->setHour(23)->setMinute(59)->setSecond(59)->isoFormat('x');

                    $sum+=$datum->score;

                    $datum->save();
                }

                $shop->score += $sum;
                $shop->save();


            });

        DB::commit();

        return back()->with('message','کدهای فرعی با موفقیت تخصیص داده شد');
    }
}
