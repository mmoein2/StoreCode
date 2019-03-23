<?php

namespace App\Http\Controllers\Api;

use App\Message;
use App\Shop;
use App\SubCode;
use Illuminate\Http\File;
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
    public function updateProfile(Request $request)
    {
        $store  = auth()->user();
        if($request->desc)
        {
            $store->desc = $request->desc;
        }
        if($request->lat)
        {
            $store->lat = $request->lat;
        }
        if($request->lng)
        {
            $store->lng= $request->lng;
        }

        $store->save();
        return['status_code'=>0];
    }
    public function updateImages(Request $request)
    {
        $shop  = auth()->user();
        $request->validate([
            'image1'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image2'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image3'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image4'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image5'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image6'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image7'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image8'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image9'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
            'image10'=>'sometimes|mimes:jpeg,png,bmp|min:10|max:10240',
        ]);

        $images= [];
        if($shop->images)
            $images=$shop->images;
        for($i=1;$i<=10;$i++)
        {
            if($request->exists('image'.$i))
            {

            $file = $request->file('image'.$i);
            $url = '/upload/shops';
            $name = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($url),$name);
            if(isset($images[$i]))
            {
                \Illuminate\Support\Facades\File::delete(public_path($images[$i]));
            }
            $images[$i]=$url.'/'.$name;

            }

        }
        $shop->images = $images;
        $shop->save();
        return['status_code'=>0];
    }
}
