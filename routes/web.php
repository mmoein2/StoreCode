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

Route::post('/payment/redirect', 'PaymentController@redirect');

Route::middleware('auth')->group(function (){
    Route::get('/','HomeController@index');


    Route::middleware('permission:subcode')->group(function (){
        Route::get('/subcode','SubCodeController@index');
        Route::get('/subcode/show','SubCodeController@show');
        Route::get('/subcode/excel','SubCodeController@excel');
        Route::post('/subcode','SubCodeController@store');
        Route::get('/assign','AssignSubCodeController@index');
        Route::post('/assign','AssignSubCodeController@store');
    });
    Route::patch('/subcode/update','SubCodeController@update')->middleware('permission:edit-subcode');
    Route::get('/subcode/delete','SubCodeController@delete')->middleware('permission:delete-subcode');
    Route::get('/subcode/edit','SubCodeController@edit')->middleware('permission:edit-subcode');
    Route::get('/subcode/return','SubCodeController@restore')->middleware('permission:delete-subcode');
    Route::post('/subcode/delete/all','SubCodeController@deleteAll')->middleware('permission:delete-subcode');
    Route::post('/subcode/edit/all','SubCodeController@editAll')->middleware('permission:edit-subcode');
    Route::post('/subcode/update/all','SubCodeController@updateAll')->middleware('permission:edit-subcode');
    Route::post('/subcode/restore/all','SubCodeController@restoreAll')->middleware('permission:delete-subcode');


    Route::middleware('permission:shop')->group(function () {

        Route::get('/shop', 'ShopController@index');
        Route::get('/shop/show', 'ShopController@show');
        Route::get('/shop/create','ShopController@create');
        Route::post('/shop','ShopController@store');
        Route::get('/shop/delete','ShopController@delete');

        Route::middleware('permission:edit-shop')->group(function () {

            Route::get('/shop/edit', 'ShopController@edit');
            Route::patch('/shop', 'ShopController@update');
        });
        Route::get('/shop/detail','ShopController@detail');
        Route::get('/shop/password/sms','ShopController@passwordSms');
        Route::post('/shop/category/modify','ShopController@modifyCategory');

    });

    Route::middleware('permission:maincode')->group(function () {

        Route::get('/maincode','MainCodeController@index');
        Route::get('/maincode/excel','MainCodeController@excel');
        Route::post('/maincode','MainCodeController@store');
        Route::get('/maincode/show','MainCodeController@show');

    });
    Route::get('/maincode/delete','MainCodeController@delete')->middleware('permission:delete-maincode');;
    Route::post('/maincode/delete/all', 'MainCodeController@deleteAll')->middleware('permission:delete-maincode');;
    Route::post('/maincode/edit/all', 'MainCodeController@editAll')->middleware('permission:edit-maincode');;
    Route::post('/maincode/update/all', 'MainCodeController@updateAll')->middleware('permission:edit-maincode');;

    Route::get('/chart', 'ChartController@index')->middleware('permission:chart');


    Route::get('/post/amount', 'PostController@index')->middleware('permission:special-post');
    Route::post('/post/amount', 'PostController@store')->middleware('permission:special-post');

    Route::middleware('permission:customer')->group(function () {

        Route::get('/customer/delete', 'CustomerController@delete');
        Route::get('/customer', 'CustomerController@index');
        Route::get('/customer/show', 'CustomerController@show');
        Route::get('/customer/show', 'CustomerController@show');
    });

    Route::middleware('permission:prize')->group(function () {


        Route::get('/prize', 'PrizeController@index');
        Route::get('/prize/create', 'PrizeController@create');
        Route::post('/prize', 'PrizeController@store');
        Route::get('/prize/edit', 'PrizeController@edit');
        Route::patch('/prize', 'PrizeController@update');
        Route::get('/prize/delete', 'PrizeController@delete');
    });

    Route::middleware('permission:shop-support')->group(function () {

        Route::get('/message', 'MessageController@index');
        Route::get('/message/show', 'MessageController@show');
    });

    Route::middleware('permission:customer-support')->group(function () {
        Route::get('/customersupport', 'CustomerSupportController@index');
        Route::get('/customersupport/show', 'CustomerSupportController@show');
    });

    Route::middleware('permission:slider')->group(function () {

        Route::get('/slider', 'SliderController@index');
        Route::get('/slider/create', 'SliderController@create');
        Route::post('/slider', 'SliderController@store');
        Route::get('/slider/delete/{id}', 'SliderController@delete');
    });
    Route::middleware('permission:change-password')->group(function () {

        Route::get('/user/change/password', 'UserController@changePasswordShow');
        Route::post('/user/change/password', 'UserController@changePassword');
    });
    Route::middleware('permission:insert-user')->group(function () {

        Route::get('/user/create', 'UserController@create');
        Route::post('/user', 'UserController@store');
        Route::get('/user', 'UserController@index');
        Route::get('/user/delete', 'UserController@delete');
        Route::get('/user/edit', 'UserController@edit');
        Route::post('/user/update', 'UserController@update');
    });
    Route::middleware('permission:update')->group(function () {

        Route::get('update', 'UpdateController@index');
        Route::get('update/delete', 'UpdateController@destroy');
        Route::get('update/create', 'UpdateController@create');
        Route::post('update', 'UpdateController@store');
        Route::post('update/update', 'UpdateController@update');
    });

});


Auth::routes();


