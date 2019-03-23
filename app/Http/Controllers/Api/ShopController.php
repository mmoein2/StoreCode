<?php

namespace App\Http\Controllers\Api;

use App\Message;
use App\SubCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function getSubCodes(Request $request)
    {
        $shop = auth()->user();
        $query = SubCode::where('shop_id',$shop->id);

        if($request->code)
        {
            $query=$query->where('code',$request->code);
        }

        if($request->serialFrom)
        {
            $query=$query->where('serial','>=',$request->serialFrom);
        }
        if($request->serialTo)
        {
            $query=$query->where('serial','<=',$request->serialTo);
        }

        if($request->status)
        {
            $s=$request->status;
            if ($s==1)
                $query=$query->where('status',1);
            else if ($s==2)
                $query=$query->where('status',2);

        }
        if($request->dateFrom)
        {
            $query=$query->where('expiration_date','>=',$request->dateFrom);

        }
        if($request->dateTo)
        {
            $query=$query->where('expiration_date','<=',$request->dateTo);
        }

        $query=$query->orderByDesc('id')->paginate();
        return [
            'status_code'=>0,
            'data'=>$query
        ];
    }
    public function storeMessage(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'text'=>'required',
        ]);

        $title = $request->title;
        $text = $request->text;

        $message = new Message();
        $message->title = $title;
        $message->text = $text;
        $message->shop_id = auth()->id();
        $message->isMessage=0;

        $message->save();
        return [
            'status_code'=>0,
        ];
    }
}
