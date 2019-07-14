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
Route::get('/clanky/{category?}/{tag?}', 'ArticlesController@index')->name('clanky');
Route::get('/clanok/{id}', 'ArticlesController@article')->name('clanok')->where('id', '[0-9]+');

//FORMULAR
Route::post('/feedback', 'FeedbackController@send');

//zmena jazyka
Route::get('/setlocale/{locale}', function ($locale) {
    if (in_array($locale, \Config::get('app.locales'))) {  
      Session::put('locale', $locale);
    }
    echo($locale.'<br><br>');
    return redirect()->back();
  });


Route::group(['middleware' => 'is.Authorized','middleware' => 'verified'], function () {      
    
    Route::get('profile', 'Admin\AdminController@index')->name('userProfile');

    //User change personal infomation
    Route::post('user/{id}', 'Admin\UsersController@editprofile')->where('id', '[0-9]+');

    //ADD COMMENT TO ARTICLE
    Route::post('article/addcoment/{article_id}', 'CommentController@save')->where('article_id', '[0-9]+');
    //REPLY TO COMMENT IN ARTICLE
    Route::post('article/reply_comment/{article_id}/{comment_id}', 'CommentController@reply')->where(['comment_id' => '[0-9]+', 'article_id' => '[0-9]+']);

      
    //EDITOR+ADMIN
    Route::middleware(['is.Editor'])->group(function () {
        //Main route
        Route::get('admin', 'Admin\AdminController@index');
        
        //Articles
        Route::get('admin/articles', 'Admin\ArticlesController@index');
        Route::get('admin/article/{lang}/{id?}', 'Admin\ArticlesController@edit')->where('id', '[0-9]+');
        Route::get('admin/deletearticle/{id}', 'Admin\ArticlesController@delete')->where('id', '[0-9]+');
        //Article changes
        Route::post('admin/article/{id?}', 'Admin\ArticlesController@save')->where('id', '[0-9]+');

        //Articles attachment delete
        Route::get('admin/attachment/delete/{id}', 'Admin\ArticlesController@attachemnt_delete')->where('id', '[0-9]+');

        //GALERY FOLDER

        Route::post('admin/connector', 'Admin\GalleryController@items');
       
        Route::post('jodit/upload', 'Admin\GalleryController@upload');
        Route::get('jodit/create', 'Admin\GalleryController@index');
        Route::get('jodit/move', 'Admin\GalleryController@index');
        Route::get('jodit/remove', 'Admin\GalleryController@index');
        Route::post('jodit/filebrowser', 'Admin\GalleryController@items');
        Route::post('jodit/tree', 'Admin\GalleryController@tree');
    
        //Ajax new category
        Route::get('savecategory/{category}/{parent_category}', 'Admin\CategoriesController@new')->where(['parent_category' => '[0-9]+']);

        //Ajax image to gallery
        Route::post('saveImagetoGalery', 'Admin\ArticlesController@newImageToGalery');

        //images left/right/delete
        Route::post('editGalery','Admin\ArticlesController@editImage');

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

            //Comments    
            Route::get('admin/comments', 'Admin\CommentsController@index');
            //Edit comments per Article
            Route::get('admin/comments/article/{article_id}', 'Admin\CommentsController@commentsPerArticle')->where('article_id', '[0-9]+');
            Route::get('admin/comment/deny/{comment_id}', 'Admin\CommentsController@commentDeny')->where('coment_id', '[0-9]+');
            Route::get('admin/comment/approve/{comment_id}', 'Admin\CommentsController@commentApprove')->where('coment_id', '[0-9]+');
            
            //Selected articles
            Route::get('admin/selectedarticles', 'Admin\ArticlesController@selectedArticles');
            Route::post('admin/selectedarticles', 'Admin\ArticlesController@selectedArticlesSave');
            //Edit comments per Article

            //CAROUSEL
            Route::get('admin/carousel', 'Admin\CarouselController@index');

            //Menu
            Route::get('admin/menu', 'Admin\MenuController@index');
            Route::get('admin/menu/{selected_sk}/{selected_en}', 'Admin\MenuController@selectedMenuChange')->where(['selected_sk' => '[0-9]+', 'selected_en' => '[0-9]+']);

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



