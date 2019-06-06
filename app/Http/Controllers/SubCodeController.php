<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceSubCode;
use App\Imports\SubCodeImport;
use App\Shop;
use App\SubCode;
use foo\bar;
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
    public function deleteAll(Request $request)
    {
        $array = $request->data;
        $array = explode(',',$array);


        DB::beginTransaction();
        foreach ($array as $item)
        {
            $subcode = SubCode::find($item);
            if($subcode->status==0)
                $subcode->delete();
            else
                return back()->withErrors(['کد با شماره ردیف '.$subcode->id.' قابل حذف نیست ']);

        }
        DB::commit();
        return back()->with(['message'=>'تعداد '.count($array).' مورد با موفقیت حذف شد']);
    }

    public function editAll(Request $request)
    {
        $array = $request->data;
        $array = explode(',',$array);



        return view('subcode.edit_all',compact('array'));
    }
    public function updateAll(Request $request)
    {
        $array = $request->data;

        $score= $request->score;
        $expiration_day = $request->day;

        DB::beginTransaction();
        foreach ($array as $item)
        {
            $s = SubCode::find($item);
            if($s->status!=0)
                return back()->withErrors(['کد با شماره ردیف '.$s->id.' قابل حذف نیست ']);
            if($score != null)
                $s->score = $score;
            if($expiration_day != null)
                $s->expiration_day = $expiration_day;
            $s->save();
        }
        DB::commit();

        return redirect('/subcode');
    }

    public function restore(Request $request)
    {

        DB::beginTransaction();
        $id = $request->id;
        $subcode = SubCode::find($id);
        if($subcode->status!=1)
        {
            return back()->withErrors(['امکان آزادسازی کد وجود ندارد']);
        }

        $shop = Shop::find($subcode->shop_id);

        $subcode->shop_id=null;
        $subcode->status=0;
        $subcode->shop_date=0;
        $subcode->expiration_date=0;

        $shop->score -= $subcode->score;

        $shop->save();
        $subcode->save();

        DB::commit();

        return back();

    }
    public function restoreAll(Request $request)
    {
        $array = $request->data;
        $array = explode(',',$array);


        DB::beginTransaction();
        foreach ($array as $item)
        {
            $subcode = SubCode::find($item);

            if($subcode->status!=1)
                return back()->withErrors(['کد '.$subcode->code.' قابل حذف نیست']);

            $shop = Shop::find($subcode->shop_id);
            $subcode->shop_id=null;
            $subcode->status=0;
            $subcode->shop_date=0;
            $subcode->expiration_date=0;

            $shop->score -= $subcode->score;

            $shop->save();
            $subcode->save();
        }
        DB::commit();

        return back();
    }

}
