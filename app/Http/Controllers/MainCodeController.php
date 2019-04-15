<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceMainCode;
use App\Imports\MainCodeImport;
use App\MainCode;
use App\Prize;
use DemeterChain\Main;
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

        if($request->scoreFrom)
        {
            $codes=$codes->where('score','>=',$request->scoreFrom);
        }
        if($request->scoreTo)
        {
            $codes=$codes->where('score','<=',$request->scoreTo);
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
        $codes=$codes->orderBy($request->sort_field??'id',$request->sort??'asc')->paginate(10);
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
    public function delete(Request $request)
    {
        try {
            MainCode::where('id',$request->id)->where('status',false)->delete();
        }
        catch (\Exception $exception)
        {
            return back()->withErrors(['امکان حذف وجود ندارد']);
        }
        return back();
    }

    public function deleteAll(Request $request)
    {
        $array = $request->data;
        $array = explode(',',$array);


        DB::beginTransaction();
        foreach ($array as $item)
        {
            $maincode = MainCode::find($item);
            if($maincode->status==false)
                $maincode->delete();
            else
                return back()->withErrors(['کد با شماره ردیف '.$maincode->id.' قابل حذف نیست ']);

        }
        DB::commit();
        return back()->with(['message'=>'تعداد '.count($array).' مورد با موفقیت حذف شد']);
    }

    public function editAll(Request $request)
    {
        $array = $request->data;
        $array = explode(',',$array);



        return view('maincode.edit_all',compact('array'));
    }
    public function updateAll(Request $request)
    {
        $array = $request->data;

        $request->validate([
            'day'=>'required|min:1|numeric',
            'score' =>'required|min:1|numeric'
        ]);
        $score= $request->score;
        $expiration_day = $request->day;

        DB::beginTransaction();
        foreach ($array as $item)
        {
            $s = MainCode::find($item);
            if($s->status==true)
                return back()->withErrors(['کد با شماره ردیف '.$s->id.' قابل حذف نیست ']);
            $s->score = $score;
            $s->expiration_day = $expiration_day;
            $s->save();
        }
        DB::commit();

        return redirect('/maincode');
    }
}
