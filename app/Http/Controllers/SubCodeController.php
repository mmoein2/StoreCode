<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceSubCode;
use App\Imports\SubCodeImport;
use App\SubCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class SubCodeController extends Controller
{
    public function index(Request $request)
    {
        $codes = SubCode::query();
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
            if($s==-1)
                $codes=$codes->where('status',0);
            else if ($s==1)
                $codes=$codes->where('status',1);
            else if ($s==2)
                $codes=$codes->where('status',2);

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
        $codes=$codes->orderBy($request->sort_field??'id',$request->sort??'asc')->paginate(10);
        return view('subcode.index',compact('codes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required',
            'day' =>'required|min:0|numeric'
        ]);
        $file = $request->file('file');

        $day = $request->day;

        DB::beginTransaction();
        try{
            Excel::import(new SubCodeImport($day), $file);


        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withErrors($e->errors());
        }
        DB::commit();
        return back()->with('message','کدهای فرعی با موفقیت ایجاد شدند');
    }
    public function show(Request $request)
    {
        $id = $request->id;
        $subcode = SubCode::find($id);
        return view('subcode.show',compact('subcode'));

    }
    public function excel()
    {
        return Excel::download(new InvoiceSubCode,'subcode_template.xls');
    }
    public function delete(Request $request)
    {
        try {
            SubCode::where('id',$request->id)->where('status',0)->delete();
        }
        catch (\Exception $exception)
        {
            return back()->withErrors(['امکان حذف وجود ندارد']);
        }
        return back();
    }
    public function edit(Request $request)
    {
        $subcode = SubCode::find($request->id);
        return view('subcode.edit',compact('subcode'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'day'=>'required|numeric',
            'score'=>'required|numeric',
        ]);
        $subcode = SubCode::where('id',$request->id)->where('status',0)->first();
        $subcode->expiration_day=$request->day;
        $subcode->score=$request->score;
        $subcode->save();
        return redirect('/subcode');
    }
}
