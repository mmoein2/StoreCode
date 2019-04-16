<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function storePost(Request $request)
    {
        $request->validate([
            'type'=>'required|min:1|max:2|numeric',
            'text'=>'required'
        ]);

        $post = new Post();
        $post->type=$request->type;
        $post->text=$request->text;
        $post->shop_id=auth()->id();

        $type = $request->type;

        //pic
        if($type==1)
        {
            $request->validate([
                'image'=>'required',
                'image_postfix'=>'required',
            ]);

            $image = $request->image;
            $image_postfix = $request->input("image_postfix");
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace('data:image/gif;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image_name = uniqid() . '.' . $image_postfix;
            $imageUrl = '/upload/posts/'.$image_name;

            \File::put(public_path($imageUrl) , base64_decode($image));
            $post->image_url=$imageUrl;

        }
        //movie
        elseif($type==2)
        {
            $request->validate([
                'aparat'=>'required',
            ]);

            $post->aparat=$request->aparat;
        }
        $post->save();
        return [
            'message'=>'0'
        ];

    }
    public function getPostAmount(Request $request)
    {
        $setting = Setting::first();
        if($setting==null)
        {
            return ['message'=>'این بخش غیر فعال است'];
        }
        if($setting->special_post_amount==0)
        {
            return ['message'=>'درحال حاضر این بخش غیرفعال است'];
        }

        return[
            'message'=>'0',
            'special_post_amount'=>$setting->special_post_amount
        ];
    }
}
