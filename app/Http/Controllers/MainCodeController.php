<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceMainCode;
use App\Imports\MainCodeImport;
use App\MainCode;
use App\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class MainCodeController extends Controller
{
    public function index(Request $request)
    {
        $prizes = Prize::get();
        $codes = MainCode::with('prize');
        if($request->code)
        {
            $codes=$codes->where('code',$request->code);
        }
        if($request->serialFrom)
        {
            $codes=$codes->where('serial','>=',$request->serialFrom);
        }
        if($request->serialTo)
        {
            $codes=$codes->where('serial','<=',$request->serialTo);
        }
        if($request->status)
        {
            $s=$request->status;
            if($s==1)
                $codes=$codes->where('status',false);
            else if ($s==2)
                $codes=$codes->where('status',true);

        }
        if($request->prize)
        {
            $codes=$codes->orWhere('status',false)->whereHas('prize',function($q) use ($request){
                $q->where('name',$request->prize);
            })
            ->orWhere('status',true)->where('prize_name',$request->prize);
        }
        if($request->dateFrom)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->dateFrom.' 00:00:00')->getTimestamp()*1000;

            $codes=$codes->where('expiration_date','>=',$ts);


        }
        if($request->dateTo)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->dateTo.' 23:59:59')->getTimestamp()*1000;
            $codes=$codes->where('expiration_date','<=',$ts);
        }
        $codes=$codes->latest()->paginate(10);
        return view('maincode.index',compact('codes','prizes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required',
            'day' =>'required|min:0|numeric'
        ]);
        $file = $request->file('file');

        $day = $request->day;

        $import=new MainCodeImport($day);
        DB::beginTransaction();
        Excel::import($import, $file);


        if( count($import->errors)>0)
        {
            return back()->withErrors($import->errors);

        }
        DB::commit();
        return back()->with('message','کدهای اصلی با موفقیت ایجاد شدند');
    }
    public function show(Request $request)
    {
        $id = $request->id;
        $maincode = MainCode::with('customer')->with('prize')->find($id);
        return view('maincode.show',compact('maincode'));

    }
    public function excel()
    {
        return Excel::download(new InvoiceMainCode,'maincode_template.xls');
    }
}
