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

        //GALERY FOLDER

        //Route::post('admin/connector', 'connector\index');
       
        Route::post('jodit/upload', 'Admin\GalleryController@upload');
        Route::get('jodit/create', 'Admin\GalleryController@index');
        Route::get('jodit/move', 'Admin\GalleryController@index');
        Route::get('jodit/remove', 'Admin\GalleryController@index');
        Route::post('jodit/filebrowser', 'Admin\GalleryController@items');
        Route::post('jodit/tree', 'Admin\GalleryController@tree');
    
        //Ajax new category
        Route::get('savecategory/{category}/{parent_category}', 'Admin\CategoriesController@new')->where(['parent_category' => '[0-9]+']);

        //ADMIN
        Route::middleware(['is.Admin'])->group(function () {
            //Users
            Route::get('admin/users', 'Admin\UsersController@index');
            Route::get('admin/user/{id?}', 'Admin\UsersController@edit')->where('id', '[0-9]+');
            Route::get('admin/deleteuser/{id?}', 'Admin\UsersController@delete')->where('id', '[0-9]+');

            //Categories
            Route::get('admin/categories', 'Admin\CategoriesController@index');
            Route::get('admin/category/{id?}', 'Admin\CategoriesController@edit')->where('id', '[0-9]+');
            Route::get('admin/deletecategory/{id?}', 'Admin\CategoriesController@delete')->where('id', '[0-9]+');
            Route::post('admin/category/{id?}', 'Admin\CategoriesController@save')->where('id', '[0-9]+');

            //Menu
            Route::get('admin/menu', 'Admin\MenuController@index');

            //Menu
            Route::group(['middleware' => config('menu.middleware')], function () {
                //Route::get('wmenuindex', array('uses'=>'\Harimayco\Menu\Controllers\MenuController@wmenuindex'));
                $path = rtrim(config('menu.route_path'));
                Route::post($path . '/addcustommenu', array('as' => 'haddcustommenu', 'uses' => '\Harimayco\Menu\Controllers\MenuController@addcustommenu'));
                Route::post($path . '/deleteitemmenu', array('as' => 'hdeleteitemmenu', 'uses' => '\Harimayco\Menu\Controllers\MenuController@deleteitemmenu'));
                Route::post($path . '/deletemenug', array('as' => 'hdeletemenug', 'uses' => '\Harimayco\Menu\Controllers\MenuController@deletemenug'));
                Route::post($path . '/createnewmenu', array('as' => 'hcreatenewmenu', 'uses' => '\Harimayco\Menu\Controllers\MenuController@createnewmenu'));
                Route::post($path . '/generatemenucontrol', array('as' => 'hgeneratemenucontrol', 'uses' => '\Harimayco\Menu\Controllers\MenuController@generatemenucontrol'));
                Route::post($path . '/updateitem', array('as' => 'hupdateitem', 'uses' => '\Harimayco\Menu\Controllers\MenuController@updateitem'));
            });
        });
    });        

});



