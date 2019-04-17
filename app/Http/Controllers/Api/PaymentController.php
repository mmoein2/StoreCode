<?php

namespace App\Http\Controllers\Api;

use App\Payment;
use App\Post;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function getToken(Request $request)
    {
        $request->validate([
            'post_id'=>'required|min:0'
        ]);
        $setting = Setting::first();
        if($setting==null)
        {
            return ['message'=>'این بخش غیر فعال است'];
        }
        if($setting->special_post_amount==0)
        {
            return ['message'=>'درحال حاضر این بخش غیرفعال است'];
        }
        $post = Post::find($request->post_id);

        if($post->is_special==true)
        {
            return ['message'=>'این پست قبلا بصورت ویژه درآمده است'];
        }

        $payment = new Payment();
        $payment->post_id = $post->id;
        $payment->date = Carbon::now()->isoFormat('x');
        $payment->amount = $setting->special_post_amount;
        $payment->shop_id = auth()->id();
        $payment->amount = $setting->special_post_amount;
        $payment->save();

        $SoapClient = new \SoapClient('https://sep.shaparak.ir/payments/initpayment.asmx',array('encoding'=>'UTF-8'));
        $token = $SoapClient->RequestToken(env('MID'), $payment->id, $setting->special_post_amount*10);
        $payment->token=$token;
        $payment->save();

        if(empty($token) || strlen($token)<5)
        {
            return [
                'message'=>'در حال حاضر امکان اتصال به درگاه وجود ندارد'
            ];
        }

        return [
            'message' => '0',
            'token' =>$token,
            'redirect_url'=>env('APP_URL').'/payment/redirect',
            'submit_url'=>'https://sep.shaparak.ir/payment.aspx'
        ];

    }
}
