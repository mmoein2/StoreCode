<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('post.index',compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $setting = Setting::first();
        if($setting==null)
        {
            $setting = new Setting();
        }
        $setting->special_post_amount=$request->amount;
        $setting->sms_money=$request->sms_money;
        $setting->notification_money=$request->notification_money;

        $setting->save();
        return back();
    }
}
