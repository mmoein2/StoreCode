<?php

namespace App\Http\Controllers\Api;

use App\ConfirmCustomer;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class ApiCustomerAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer_api', ['except' => ['login','loginConfirm']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {

        $request->validate([
            'mobile'=>'required'
        ]);

        $mobile = $request->mobile;
        $customer = Customer::where('mobile',$mobile)->first();
        if($customer==null)
        {
            return [
                'message'=>'شماره موبایل در سیستم وجود ندارد'
            ];

        }

        $cc = new ConfirmCustomer();
        $cc->token=substr(md5(uniqid(rand(), true)),0,4);
        $cc->customer_id=$customer->id;
        $cc->save();

        Smsirlaravel::send('رمز موقت شما : '.$cc->token,[$customer->mobile]);

        return [
            'message'=>'0'
        ];


    }
    public function loginConfirm(Request $request)
    {
        $request->validate([
            'token'=>'required'
        ]);

        $token= $request->token;
        $cc = ConfirmCustomer::with('customer')->where('token',$token)->where('created_at','>=',Carbon::now()->subHours(24))->where('is_burned',false)->latest()->first();
        if($cc==null)
        {
            return [
                'message' =>'کد ارسالی اشتباه است'
            ];
        }
        $cc->is_burned=true;
        $cc->save();
        $customer = $cc->customer;
        if($request->play_id)
        {

            $play_id = $request->play_id;
            $customer->play_id=$play_id;
            $customer->save();
        }

        Auth::shouldUse('customer_api');
        $token = auth()->login($customer);

        return [
            'message'=>'0',
            'access_token' =>$token
        ];
    }



    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        $id = auth()->id();
        $customer=Customer::with(['city','province'])->find($id);
        return response()->json($customer);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


}