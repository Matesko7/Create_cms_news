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
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();


Route::group(['middleware' => 'is.Authorized'], function () {  
    //ADMIN
    Route::group(['middleware' => 'is.Admin'], function () {
        //Articles
        Route::get('admin/editarticle/{id}', 'Admin\AdminController@edit');
        Route::get('admin/deletearticle/{id}', 'Admin\AdminController@delete');
    });        

});



