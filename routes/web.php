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
    
    Route::get('/profile', 'Admin\AdminController@index')->name('userProfile');

    //User change personal infomation
    Route::post('/user/{id}', 'Admin\UsersController@editprofile')->where('id', '[0-9]+');

    
    //ADMIN
    Route::middleware(['is.Admin'])->group(function () {
        //Main route
        Route::get('admin', 'Admin\AdminController@index');
        
        //Articles
        Route::get('admin/articles', 'Admin\ArticlesController@index');
        Route::get('admin/article/{id?}', 'Admin\ArticlesController@edit')->where('id', '[0-9]+');
        Route::get('admin/deletearticle/{id}', 'Admin\ArticlesController@delete')->where('id', '[0-9]+');
        //Article changes
        Route::post('admin/article/{id?}', 'Admin\ArticlesController@save')->where('id', '[0-9]+');
    

        //Users
        Route::get('admin/users', 'Admin\UsersController@index');
        Route::get('admin/user/{id?}', 'Admin\UsersController@edit')->where('id', '[0-9]+');
        Route::get('admin/deleteuser/{id?}', 'Admin\UsersController@delete')->where('id', '[0-9]+');

        //Ajax new category
        Route::get('/savecategory/{category}', 'Admin\CategoryController@new')->where('category', '[A-Za-z0-9]+');
    });        

});



