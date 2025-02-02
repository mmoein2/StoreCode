<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth/customer','namespace'=>'Api'], function ($router) {

    Route::post('login', 'ApiCustomerAuthController@login');
    Route::post('login/confirm', 'ApiCustomerAuthController@loginConfirm');

    Route::post('logout', 'ApiCustomerAuthController@logout');
   // Route::post('refresh', 'ApiCustomerAuthController@refresh');
    Route::post('me', 'ApiCustomerAuthController@me');


});

Route::group(['prefix' => 'auth/shop','namespace'=>'Api'], function ($router) {

    Route::post('login', 'ApiShopAuthController@login');
    Route::post('logout', 'ApiShopAuthController@logout');
  //  Route::post('refresh', 'ApiShopAuthController@refresh');
    Route::post('me', 'ApiShopAuthController@me');
    Route::post('password/recovery', 'ApiShopAuthController@passwordRecovery');
    Route::post('confirm/password/recovery', 'ApiShopAuthController@confirmPasswordRecovery');

});

//api for sms
Route::group(['namespace'=>'Api'], function ($router) {
    Route::get('subcode/register', 'SubCodeController@register');
    Route::get('slider', 'SliderController@index');

    Route::post('province', 'CustomerController@getProvince');
    Route::post('city', 'CustomerController@getCity');


});

//api for customer
Route::group(['namespace'=>'Api','prefix'=>'customer','middleware'=>'auth:customer_api'], function ($router) {

    Route::post('maincode/register', 'MainCodeController@register');
    Route::post('posts/show', 'CustomerController@showPosts');
    Route::post('follow', 'CustomerController@follow');
    Route::post('unfollow', 'CustomerController@unFollow');
    Route::post('shops', 'CustomerController@shops');
    Route::post('subcode/index', 'CustomerController@getSubCodes');
    Route::post('maincode/all', 'MainCodeController@all');
    Route::post('maincode/index', 'MainCodeController@index');
    Route::post('message/store', 'CustomerController@storeMessage');
    Route::post('profile/update', 'CustomerController@updateProfile');

    Route::post('prize/all', 'MainCodeController@getPrizeCategory');

    Route::post('shop/category', 'ShopController@shopCategory');




});

//api for shop
Route::group(['namespace'=>'Api','prefix'=>'shop','middleware'=>'auth:shop_api'], function ($router) {

    Route::post('subcode/index', 'ShopController@getSubCodes');
    Route::post('message/store', 'ShopController@storeMessage');
    Route::post('post/store', 'PostController@storePost');
    Route::post('profile/update', 'ShopController@updateProfile');
    Route::post('profile/images/update', 'ShopController@updateImages');
    Route::post('posts/special/amount', 'PostController@getPostAmount');
    Route::post('payment/token', 'PaymentController@getToken');
    Route::post('customers', 'ShopController@customers');
    Route::post('subcode/variaty', 'ShopController@getSubcodeVariaty');
    Route::post('discount', 'ShopController@registerDiscount');
    Route::post('discount/history', 'ShopController@historyDiscount');
    Route::post('discount/burn', 'ShopController@discountBurned');

    Route::post('send/message', 'ShopController@registerMessage');


});
Route::post('/shop/register', 'Api\ShopController@register');
Route::post('/customer/register', 'Api\CustomerController@register');

Route::post('/update/check', 'Api\UpdateController@checkUpdate');
