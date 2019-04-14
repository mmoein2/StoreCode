<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/','Auth\LoginController@showLoginForm');

Route::middleware('auth')->group(function (){


    Route::middleware('role:admin')->group(function () {
        Route::get('/subcode','SubCodeController@index');
        Route::get('/subcode/show','SubCodeController@show');
        Route::get('/subcode/excel','SubCodeController@excel');
        Route::post('/subcode','SubCodeController@store');
        Route::get('/subcode/delete','SubCodeController@delete');
        Route::get('/subcode/edit','SubCodeController@edit');;
        Route::patch('/subcode/update','SubCodeController@update');

        Route::get('/assign','AssignSubCodeController@index');
        Route::post('/assign','AssignSubCodeController@store');
    });


    Route::get('/shop','ShopController@index');
    Route::get('/shop/show','ShopController@show');


    Route::post('/subcode/delete/all','SubCodeController@deleteAll');
    Route::post('/subcode/edit/all','SubCodeController@editAll');
    Route::post('/subcode/update/all','SubCodeController@updateAll');

    Route::post('/maincode/delete/all','MainCodeController@deleteAll');
    Route::post('/maincode/edit/all','MainCodeController@editAll');
    Route::post('/maincode/update/all','MainCodeController@updateAll');

    Route::middleware('role:admin')->group(function () {
        Route::get('/shop/create','ShopController@create');
        Route::post('/shop','ShopController@store');
        Route::get('/shop/delete','ShopController@delete');
        Route::get('/shop/edit','ShopController@edit');
        Route::patch('/shop','ShopController@update');
        Route::get('/shop/detail','ShopController@detail');
        Route::get('/shop/password/sms','ShopController@passwordSms');
        Route::post('/shop/category/modify','ShopController@modifyCategory');

    });


    Route::middleware('role:admin')->group(function () {
        Route::get('/customer/delete','CustomerController@delete');


        Route::get('/maincode','MainCodeController@index');
        Route::get('/maincode/excel','MainCodeController@excel');
        Route::post('/maincode','MainCodeController@store');
        Route::get('/maincode/show','MainCodeController@show');
        Route::get('/maincode/delete','MainCodeController@delete');

    });

    Route::get('/customer','CustomerController@index');
    Route::get('/customer/show','CustomerController@show');


    Route::middleware('role:admin')->group(function (){
        Route::get('/prize','PrizeController@index');
        Route::get('/prize/create','PrizeController@create');
        Route::post('/prize','PrizeController@store');
        Route::get('/prize/edit','PrizeController@edit');
        Route::patch('/prize','PrizeController@update');
        Route::get('/prize/delete','PrizeController@delete');

        Route::get('/message','MessageController@index');
        Route::get('/message/show','MessageController@show');

        Route::get('/customersupport','CustomerSupportController@index');
        Route::get('/customersupport/show','CustomerSupportController@show');

        Route::get('/slider','SliderController@index');
        Route::get('/slider/create','SliderController@create');
        Route::post('/slider','SliderController@store');
        Route::get('/slider/delete/{id}','SliderController@delete');

        Route::get('/user/change/password','UserController@changePasswordShow');
        Route::post('/user/change/password','UserController@changePassword');
        Route::get('/user/create','UserController@create');
        Route::post('/user','UserController@store');
        Route::get('/user','UserController@index');
        Route::get('/user/delete','UserController@delete');

    });

});


Auth::routes();


