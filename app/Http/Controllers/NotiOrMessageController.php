<?php

namespace App\Http\Controllers;

use App\NotiOrMessage;
use App\NotiOrMessageMember;
use App\Utility\FireBase;
use Illuminate\Http\Request;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class NotiOrMessageController extends Controller
{
    public function index()
    {
        $data = NotiOrMessage::latest()->paginate();
        return view('Noti.index',compact('data'));
    }
    public function verify($id)
    {
        $n = NotiOrMessage::find($id);
        $data = NotiOrMessageMember::where('noti_or_message_id',$id)->get();
        if($n->type==1)
        {
            foreach ($data as $d)
            {
                $firebase = new FireBase();
                $firebase->send($d->customer->play_id,$n->text);
            }
        }
        elseif($n->type==2)
        {
            foreach ($data as $d)
            {
                Smsirlaravel::send($n->text,$d->customer->mobile);

            }
        }
        $n->status=2;
        $n->save();
        return back();

    }
}
