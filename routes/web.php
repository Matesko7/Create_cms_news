<?php
use App\Page;
use App\Page_component;

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



//ROUTES CREATED BY ADMIN
$menu_id=false;
if(App::isLocale('sk')){
    if(DB::select("SELECT id FROM admin_menus WHERE selected_sk = 1"))
        $menu_id = DB::select("SELECT id FROM admin_menus WHERE selected_sk = 1")[0]->id;
} else{
    if(DB::select("SELECT id FROM admin_menus WHERE selected_en =1"))
        $menu_id = DB::select("SELECT id FROM admin_menus WHERE selected_en =1")[0]->id;
}

if($menu_id){
    $routes = DB::select("SELECT * FROM admin_menu_items WHERE menu = $menu_id");

    foreach ($routes as $key => $route) {
        if(Page::where('menu_item_id', $route->id)->first()){
            $page_id = Page::where('menu_item_id', $route->id)->get()[0]->id;
            $page_components= Page_component::select('component_id')->where('page_id', $page_id)->orderBy('component_order')->get();
            foreach ($page_components as $key => $value) {
                //8 = KOPONENT CLANKY
                if($value->component_id == 8){
                    if($route->link == "/") $route->link="";
                    Route::get($route->link.'/filter/{category?}/{tag?}','PageController@handle')->name($route->id);
                    Route::get('/clanok/{id}','PageController@handle')->name('article_single|'.$route->id); 
                }
            }
        }
        Route::get($route->link,'PageController@handle')->name($route->id);
    }
}


//Route::get('/','Controller@index')->name('index');
// Route::get('/sluzby', 'Controller@sluzby')->name('sluzby');
// Route::get('/home', 'HomeController@index')->name('home');

// LINKS FOR ARCTICLE KOMPONENT
// Route::get('/clanky/{category?}/{tag?}', 'ArticlesController@index')->name('clanky');
// Route::get('/clanok/{id}', 'ArticlesController@article')->name('clanok')->where('id', '[0-9]+');

//FORMULAR
Route::post('/feedback', 'FeedbackController@send');


//LOGIN
Auth::routes(['verify' => true]);

//LANGUAGE CHANGE
Route::get('/setlocale/{locale}', function ($locale) {
    if (in_array($locale, \Config::get('app.locales'))) {  
      Session::put('locale', $locale);
    }
    echo($locale.'<br><br>');
    return redirect()->back();
});

//SITEMAP
Route::get('sitemap', 'SitemapController@articles');

//USER
Route::get('user/{id}', 'PageController@handle')->name('user');

//NEWSLETTER
Route::get('newsletter_registration', 'Admin\NewsletterController@saveSubscriber');
Route::get('newsletter/unsubscribe/{id}/{hash}', 'Admin\NewsletterController@unsubscribe')->where('id', '[0-9]+');


//VOTING
Route::get('voting', 'Admin\VotingController@saveVote');



Route::group(['middleware' => 'is.Authorized','middleware' => 'verified'], function () {      
    
    Route::get('profile', 'Admin\AdminController@index')->name('userProfile');

    //User want to change password
    Route::get('user/changepassword/{id}', 'Admin\UsersController@editPassword')->where('id', '[0-9]+');
    
    //User change password
    Route::post('user/changepassword/{id}', 'Admin\UsersController@changepassword')->where('id', '[0-9]+');

    
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

        //Ajax image to Article gallery
        Route::post('saveImagetoGalery', 'Admin\ArticlesController@newImageToGalery');
        
        //Ajax image to component gallery
        Route::post('saveImagetoComponentGalery', 'Admin\ComponentsController@newImageToGallery');
        
        //Ajax image to component CAROUSEL
        Route::post('saveImagetoComponentCarousel', 'Admin\ComponentsController@newImageToCarousel');

        //Ajax related article ADD
        Route::post('saveRelatedArticle', 'Admin\ArticlesController@newRelatedArcticle');

        //Ajax related article DELETE
        Route::get('deleteRelatedArcticle/{id}', 'Admin\ArticlesController@deleteRelatedArcticle')->where('id', '[0-9]+');


        //images in article left/right/delete
        Route::post('editGalery','Admin\ArticlesController@editImage');
        
        //images in component gallery
        Route::post('editComponentGalery','Admin\ComponentsController@editImage');
        
        //images in component CAROUSEL
        Route::post('editComponentCarousel','Admin\ComponentsController@editImageInCarousel');

        //COMPONENTS
        Route::get('admin/components', 'Admin\ComponentsController@index');
        Route::get('admin/component', 'Admin\ComponentsController@new');
        Route::get('admin/components/edit/{id}', 'Admin\ComponentsController@edit')->where('id', '[0-9]+');
        Route::get('admin/components/delete/{id}', 'Admin\ComponentsController@delete')->where('id', '[0-9]+');
        Route::post('admin/component/{id?}', 'Admin\ComponentsController@save')->where('id', '[0-9]+');
        Route::post('admin/component_rename', 'Admin\ComponentsController@rename')->where('id', '[0-9]+');

        //COMPONENT ABOUT EDIT
        Route::post('admin/component/edit/about/{id?}', 'Admin\ComponentsController@about')->where('id', '[0-9]+');

        //COMPONENT MAP EDIT
        Route::post('admin/component/edit/map/{id?}', 'Admin\ComponentsController@map')->where('id', '[0-9]+');
        
        //COMPONENT ARTICLES EDIT
        Route::post('admin/component/edit/articles/{id?}', 'Admin\ComponentsController@articles')->where('id', '[0-9]+');

    });  

    //ADMIN
    Route::middleware(['is.Admin'])->group(function () {
            
        //Clear cache
        Route::get('/clear-cache', function() {
          Artisan::call('cache:clear');
          Artisan::call('config:clear');
          Artisan::call('view:clear');
          $options= DB::select("SELECT A.id,A.value,A.type_id,B.name FROM general_options as A LEFT JOIN general_options_types as B ON A.type_id =B.id");
          return back()->with(['success' => 'Vymazanie cache prebehlo úspešne','options' => $options]);
        });

        //Users
        Route::get('admin/users', 'Admin\UsersController@index');
        Route::get('admin/user/{action}/{id}', 'Admin\UsersController@blockOrUnblock')->where('id', '[0-9]+');

        //User change password
        Route::get('admin/passwordChange/{id}', 'Admin\UsersController@AdminEditPassword')->where('id', '[0-9]+');
        Route::post('admin/passwordChange/{id}', 'Admin\UsersController@Adminchangepassword')->where('id', '[0-9]+');
        
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
    
        //GENERAL OPTIONS
        Route::get('admin/options', 'Admin\OptionsController@index');
        Route::get('admin/option/{id?}', 'Admin\OptionsController@edit')->where('id', '[0-9]+');
        Route::get('admin/deleteoption/{id}', 'Admin\OptionsController@delete')->where('id', '[0-9]+');
        Route::post('admin/option/{id?}', 'Admin\OptionsController@save')->where('id', '[0-9]+');
        
        //PAGES
        Route::get('admin/pages', 'Admin\PagesController@index');
        Route::get('admin/pages/edit/{id?}', 'Admin\PagesController@edit');
        Route::get('admin/pages/delete/{id?}', 'Admin\PagesController@deletePage');

        Route::post('admin/pages/saveNewComponent',  'Admin\PagesController@saveComponent');
        Route::post('admin/pages/deleteComponent',  'Admin\PagesController@deleteComponent');
        Route::post('admin/pages/changeOrderOfComponents',  'Admin\PagesController@changeOrderOfComponents');
        
        Route::get('admin/pages/addMenuItemToPage/{id_page}/{id_menuItem}', 'Admin\PagesController@addMenuItemToPage');
        Route::post('admin/pages/{id}',  'Admin\PagesController@save');

        //NEWSLETTER
        Route::get('admin/newsletter', 'Admin\NewsletterController@index');
        Route::get('admin/deleteSubscriber/{id}', 'Admin\NewsletterController@deleteSubscriber')->where('id', '[0-9]+');
        Route::get('admin/refreshSubscriber/{id}', 'Admin\NewsletterController@refreshSubscriber')->where('id', '[0-9]+');
        Route::get('admin/email/{id?}', 'Admin\NewsletterController@email');
        Route::post('admin/email/{id?}', 'Admin\NewsletterController@saveEmail');
        Route::get('admin/deleteEmail/{id}', 'Admin\NewsletterController@deleteEmail')->where('id', '[0-9]+');
        Route::get('admin/sendEmail/{id}', 'Admin\NewsletterController@sendEmail')->where('id', '[0-9]+');
        Route::post('admin/sendTestEmail', 'Admin\NewsletterController@sendTestEmail')->where('id', '[0-9]+');

        //VOTING
        Route::post('admin/voting/saveNewOption',  'Admin\VotingController@saveOption');
        Route::post('admin/voting/deleteOption',  'Admin\VotingController@deleteOption');
        Route::post('admin/voting/changeOrderOfOptions',  'Admin\VotingController@changeOrderOfOptions');
        Route::post('admin/voting/saveNewQuestion/{id}',  'Admin\VotingController@saveQuestion')->where('id', '[0-9]+');
        

        //Menu
        Route::get('admin/menu', 'Admin\MenuController@showMenus');
        Route::get('admin/menu/delete/{menuId}', 'Admin\MenuController@deleteMenu')->where(['menuId' => '[0-9]+']);
        Route::get('admin/menu/{lang}/{menuId}', 'Admin\MenuController@selectedMenuChange')->where(['menuId' => '[0-9]+']);
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

