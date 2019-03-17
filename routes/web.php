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

Route::get('/assign','AssignSubCodeController@index');
Route::post('/assign','AssignSubCodeController@store');

Route::resource('/shop','ShopController');

