<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::with('shop');

        if($request->title)
        {
            $messages=$messages->where('title','like','%'.$request->title.'%');
        }
        if($request->shop_name)
        {
            $messages=$messages->whereHas('shop',function ($q) use ($request){
                $q->where('name','like','%'.$request->shop_name.'%');
            });
        }
        if($request->status)
        {
            if($request->status==1)
                $messages=$messages->where('IsMessage',true);
            elseif($request->status==-1)
                $messages=$messages->where('IsMessage',false);


        }
        $messages = $messages->select(['title','created_at','IsMessage','shop_id','id'])->latest()->paginate();
        return view('message.index',compact('messages'));
    }
    public function show(Request $request)
    {
        $message = Message::find($request->id);
        $message->IsMessage=true;
        $message->save();
        return view('message.show',compact('message'));
    }
}
