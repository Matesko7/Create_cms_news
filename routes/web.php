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

Route::get('/test','Controller@test')->name('test');

Auth::routes(['verify' => true]);


Route::get('/','Controller@index')->name('index');
Route::get('/sluzby', 'Controller@sluzby')->name('sluzby');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clanky', 'ArticlesController@index')->name('clanky');
Route::get('/clanok/{id}', 'ArticlesController@article')->name('clanok')->where('id', '[0-9]+');

//FORMULAR
Route::post('/feedback', 'FeedbackController@send');


Route::group(['middleware' => 'is.Authorized','middleware' => 'verified'], function () {      
    
    Route::get('profile', 'Admin\AdminController@index')->name('userProfile');

    //User change personal infomation
    Route::post('user/{id}', 'Admin\UsersController@editprofile')->where('id', '[0-9]+');

      
    //EDITOR+ADMIN
    Route::middleware(['is.Editor'])->group(function () {
        //Main route
        Route::get('admin', 'Admin\AdminController@index');
        
        //Articles
        Route::get('admin/articles', 'Admin\ArticlesController@index');
        Route::get('admin/article/{id?}', 'Admin\ArticlesController@edit')->where('id', '[0-9]+');
        Route::get('admin/deletearticle/{id}', 'Admin\ArticlesController@delete')->where('id', '[0-9]+');
        //Article changes
        Route::post('admin/article/{id?}', 'Admin\ArticlesController@save')->where('id', '[0-9]+');
    
        //Ajax new category
        Route::get('savecategory/{category}/{parent_category}', 'Admin\CategoryController@new')->where(['parent_category' => '[0-9]+']);

        Route::middleware(['is.Admin'])->group(function () {
            //Users
            Route::get('admin/users', 'Admin\UsersController@index');
            Route::get('admin/user/{id?}', 'Admin\UsersController@edit')->where('id', '[0-9]+');
            Route::get('admin/deleteuser/{id?}', 'Admin\UsersController@delete')->where('id', '[0-9]+');
        });
    });        

});



