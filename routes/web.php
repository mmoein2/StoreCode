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

Route::get('/subcode','SubCodeController@index');
Route::get('/subcode/excel','SubCodeController@excel');
Route::post('/subcode','SubCodeController@store');
Route::get('/subcode/show','SubCodeController@show');

Route::get('/assign','AssignSubCodeController@index');
Route::post('/assign','AssignSubCodeController@store');

Route::get('/shop','ShopController@index');
Route::get('/shop/create','ShopController@create');
Route::post('/shop','ShopController@store');
Route::get('/shop/show','ShopController@show');

Route::post('/shop/category/modify','ShopController@modifyCategory');

Route::get('/customer','CustomerController@index');
Route::get('/customer/show','CustomerController@show');


Route::get('/maincode','MainCodeController@index');
Route::get('/maincode/excel','MainCodeController@excel');
Route::post('/maincode','MainCodeController@store');
Route::get('/maincode/show','MainCodeController@show');
