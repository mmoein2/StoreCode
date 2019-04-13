<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Utility\FireBase;
use App\MainCode;
use App\SubCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Morilog\Jalali\Jalalian;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with(['province','city']);

        if($request->id)
        {
            $customers = $customers->where('id',$request->id);
        }
        if($request->mobile)
        {
            $customers = $customers->where('mobile','like','%'.$request->mobile.'%');
        }
        if($request->scoreFrom)
        {
            $customers = $customers->where('score','>=',$request->scoreFrom);
        }
        if($request->scoreTo)
        {
            $customers = $customers->where('score','<=',$request->scoreTo);
        }

        if($request->availableScoreFrom)
        {
            $customers = $customers->where(DB::raw('score - used_score'),'>=',$request->availableScoreFrom);
        }
        if($request->availableScoreTo)
        {
            $customers = $customers->where(DB::raw('score - used_score'),'<=',$request->availableScoreTo);
        }

        if($request->registrationDateFrom)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->registrationDateFrom.' 00:00:00')->getTimestamp()*1000;
            $customers=$customers->where('registration_date','>=',$ts);


        }
        if($request->registrationDateTo)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->registrationDateTo.' 23:59:59')->getTimestamp()*1000;
            $customers=$customers->where('registration_date','<=',$ts);
        }
        if($request->sort_field=='available_score')
        {
            $customers = $customers->orderBy(DB::raw('score - used_score'),$request->sort??'desc');

        }
        else
        {

            $customers = $customers->orderBy($request->sort_field??'created_at',$request->sort??'asc');
        }

        if($request->command)
        {
            if(auth()->user()->role->name_en!='admin')
                return back()->withErrors(['دسترسی غیر مجاز']);
            $message = ($request->message);

            if($request->command=="message")
            {

                $customers=$customers->pluck('mobile');
                $res = Smsirlaravel::send($message,$customers->toArray());
                if($res['IsSuccessful']==true)
                    return back()->with(['message'=>'پیام با موفقیت ارسال شد']);
                else
                    return back()->withErrors([$res['Message']]);

            }
            elseif($request->command=="notification")
            {
                $customers = $customers->where('play_id','!=',null);
                $customers= $customers->pluck('play_id');
                $firebase = new FireBase();

                foreach ($customers as $c)
                {
                    $firebase->send($c,$message);
                }

            }
            return back()->with(['message'=>'نوتیفیکیشن ارسال شد']);

        }
        else
        {

        $customers=$customers->paginate();

        return view('customer.index',compact('customers'));
        }

    }

    public function show(Request $request)
    {
        $id =  $request->id;
        $customer = Customer::with(['city','province'])->find($id);
        $subcodes = SubCode::with('shop')->with('customer')->where('status',2)->where('customer_id',$id);
        if($request->s_code)
        {
            $subcodes = $subcodes->where('code',$request->s_code);
        }

        if($request->s_serialFrom)
        {
            $subcodes = $subcodes->where('serial','>=',$request->s_serialFrom);
        }
        if($request->s_serialTo)
        {
            $subcodes = $subcodes->where('serial','<=',$request->s_serialTo);
        }

        if($request->s_scoreFrom)
        {
            $subcodes = $subcodes->where('score','>=',$request->s_scoreFrom);
        }
        if($request->s_scoreTo)
        {
            $subcodes = $subcodes->where('score','<=',$request->s_scoreTo);
        }
        if($request->s_dateFrom)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->s_dateFrom.' 00:00:00')->getTimestamp()*1000;
            $subcodes=$subcodes->where('customer_date','>=',$ts);


        }
        if($request->s_dateTo)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->s_dateTo.' 23:59:59')->getTimestamp()*1000;
            $subcodes=$subcodes->where('customer_date','<=',$ts);
        }

        if($request->shop_name)
        {
            $subcodes = $subcodes->whereHas('shop',function ($q) use ($request){
                $q->where('name','like','%'.$request->shop_name.'%');
            });
        }
        $subcodes = $subcodes->orderBy('id','asc')->paginate(null,['*'],'subcode_page');


        $subcodes->setPageName('subcode_page');

        $maincodes = MainCode::with('shop')->with('customer')->with('prize')->where('status',true)->where('customer_id',$id);

        if($request->m_code)
        {
            $maincodes = $maincodes->where('code',$request->m_code);
        }

        if($request->m_serialFrom)
        {
            $maincodes = $maincodes->where('serial','>=',$request->m_serialFrom);
        }
        if($request->m_serialTo)
        {
            $maincodes = $maincodes->where('serial','<=',$request->m_serialTo);
        }
        if($request->m_prize)
        {
            $maincodes = $maincodes->where('prize_name',$request->m_prize);
        }


        if($request->m_dateFrom)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->m_dateFrom.' 00:00:00')->getTimestamp()*1000;
            $maincodes=$maincodes->where('customer_date','>=',$ts);


        }
        if($request->m_dateTo)
        {
            $ts =Jalalian::fromFormat('Y/m/d H:i:s',$request->m_dateTo.' 23:59:59')->getTimestamp()*1000;
            $maincodes=$maincodes->where('customer_date','<=',$ts);
        }

        $maincodes = $maincodes->orderBy($request->sort_field??'id',$request->sort??'asc')->paginate(null,['*'],'maincode_page');

        $maincodes->setPageName('maincode_page');

        return view('customer.show',compact('customer','subcodes','maincodes'));
    }
    public function delete(Request $request)
    {
        $c= Customer::find($request->id);
        $c->status=!($c->status);
        $c->save();
        return back();
    }
}
