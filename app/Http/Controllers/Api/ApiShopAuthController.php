<?php

namespace App\Http\Controllers\Api;

use App\ConfirmShop;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class ApiShopAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:shop_api', ['except' => ['login','passwordRecovery','confirmPasswordRecovery']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        Auth::shouldUse('shop_api');
        $mobile = $request->mobile;
        $password = $request->password;
        $shop = Shop::where('mobile',$mobile)->where('password',$password)->first();
        if($shop==null)
        {
            return [
                'status_code'=>1,
                'message'=>'شماره موبایل یا پسورد صحیح نیست'
            ];
        }

        if($request->play_id)
        {

            $play_id = $request->play_id;
            $shop->play_id=$play_id;
            $shop->save();
        }
        $token = (auth()->login($shop));
        return [
            'status_code'=>0,
            'access_token'=>$token
        ];
    }

    public function passwordRecovery(Request $request)
    {
        $request->validate([
            'mobile'=>'required|min:11|max:11'
        ]);

        $mobile = $request->mobile;
        $shop = Shop::where('mobile',$mobile)->first();
        if($shop==null)
        {
            return [
                'status_code' =>1,
                'message' =>'شماره موبایل در سیستم وجود ندارد'
            ];
        }
        $cs = new ConfirmShop();
        $cs->shop_id=$shop->id;
        $cs->token=substr(md5(uniqid(rand(), true)),0,4);
        $cs->save();

        Smsirlaravel::send('رمز موقت شما : '.$cs->token,[$shop->mobile]);

        return [
            'status_code' =>0,
        ];
    }

    public function confirmPasswordRecovery(Request $request)
    {
        $request->validate([
            'token'=>'required'
        ]);

        $token= $request->token;
        $cs = ConfirmShop::with('shop')->where('token',$token)->where('created_at','>=',Carbon::now()->subHours(24))->where('is_burned',false)->latest()->first();
        if($cs==null)
        {
            return [
                'status_code' =>1,
                'message' =>'کد ارسالی اشتباه است'
            ];
        }
        $cs->is_burned=true;
        $cs->save();

        $shop = $cs->shop;
        Auth::shouldUse('shop_api');
        $token = auth()->login($shop);

        return [
            'status_code' =>0,
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
        return response()->json(auth()->user());
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

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}