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
    Route::post('logout', 'ApiCustomerAuthController@logout');
   // Route::post('refresh', 'ApiCustomerAuthController@refresh');
    Route::post('me', 'ApiCustomerAuthController@me');

});

Route::group(['prefix' => 'auth/shop','namespace'=>'Api'], function ($router) {

    Route::post('login', 'ApiShopAuthController@login');
    Route::post('logout', 'ApiShopAuthController@logout');
  //  Route::post('refresh', 'ApiShopAuthController@refresh');
    Route::post('me', 'ApiShopAuthController@me');

});