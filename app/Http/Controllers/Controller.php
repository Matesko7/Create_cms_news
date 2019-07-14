<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index(){
        $config = array();
        $config['center'] = '48.1834461513518, 17.099425792694092';
        $config['zoom'] = '14';

        $marker = array();
        $marker['position'] = '48.1834461513518, 17.099425792694092';
        $marker['infowindow_content'] = "<img style='margin:10px;height:75px;' src=".asset('grafika/grafika/na_boboch.png')."><p><b>Bratislavská bobová dráha</b></p><p>Cesta na Kamzík<br>831 01 Nové Mesto</p><p><span>email: ba.bobova@gmail.com <br>tel: +421 918 683 202</span></p>";
  
        \GMaps::add_marker($marker);
        \GMaps::initialize($config);
        $map = \GMaps::create_map();

        //novinky
        $news = DB::select("SELECT articles.*, users.name as author FROM articles LEFT JOIN users on articles.user_id=users.id order by created_at limit 6");

        //vybrané články
        $selected = DB::select("SELECT articles.*, users.name as author FROM articles LEFT JOIN users on articles.user_id=users.id WHERE selected_article !=0 order by selected_article limit 6");

        
        return view('index', ['map' => $map, 'news' => $news, 'selected_articles' => $selected]);
    }

    public function sluzby(){
        return view('sluzby');
    }

    public function test(){
        return view('demo');
    }

}
