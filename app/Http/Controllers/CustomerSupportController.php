<?php

namespace App\Http\Controllers;

use App\CustomerSupport;
use Illuminate\Http\Request;
class CustomerSupportController extends Controller
{
    public function index(Request $request)
    {
        $customer = CustomerSupport::with('customer');

        if($request->title)
        {
            $customer=$customer->where('title','like','%'.$request->title.'%');
        }
        if($request->customer_name)
        {
            $customer=$customer->whereHas('customer',function ($q) use ($request){
                $q->where('fullname','like','%'.$request->customer_name.'%');
            });
        }
        if($request->status)
        {
            if($request->status==1)
                $customer=$customer->where('status',true);
            elseif($request->status==-1)
                $customer=$customer->where('status',false);


        }
        $customer = $customer->select(['title','created_at','status','customer_id','id'])->latest()->paginate();
        return view('customersupport.index',compact('customer'));
    }
    public function show(Request $request)
    {
        $customer = CustomerSupport::with('customer')->find($request->id);
        $customer->status=true;
        $customer->save();
        return view('customersupport.show',compact('customer'));
    }
}
