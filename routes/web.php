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

Route::get('/','Controller@index');

// routes for login
Route::get('/login', 'LoginController@index');
Route::post('/login/checklogin', 'LoginController@checklogin');

Route::group(['middleware' => 'is.Authorized'], function () {
    //ADMIN-LOGIN
    Route::get('/logout', 'LoginController@logout');
    Route::get('/successlogin', 'Admin\AdminController@index');
});
