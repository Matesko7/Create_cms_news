<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Category;
use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{
    public function articles(){
        $links= [];
        $articles_links_tmp ="";
        $articles_links= [];
        
        $articles = Article::all();
        $categories = Category::all();


        $articles_links_tmp = DB::select("SELECT C.link,D.selected_sk,D.selected_en FROM `page_components` A LEFT JOIN pages B ON A.page_id= B.id LEFT JOIN admin_menu_items C ON B.menu_item_id= C.id LEFT JOIN admin_menus D ON C.menu= D.id WHERE A.component_id='8' AND (D.selected_sk= '1' OR D.selected_en = '1' )");
        if($articles_links_tmp){
            foreach ($articles_links_tmp as $key => $value) {
                    array_push($articles_links,$value->link);
            }
        }
        if($articles_links){
            foreach ($articles_links as $key => $value) {
                foreach ($categories as $key => $value2) {
                    array_push($links,asset($value). "/filter". "/". $value2->id."/0");
                }
            }
        }
            
        $links_tmp= DB::select(" SELECT A.link from admin_menu_items A LEFT JOIN admin_menus B ON A.menu=B.id WHERE B.selected_sk= '1' OR B.selected_en= '1'");
        foreach ($links_tmp as $key => $value) {
            array_push($links,asset($value->link));
        }
        foreach ($articles as $key => $value) {
            array_push($links,asset('clanok/'.$value->id));
        }
        
        return response()->view('sitemap.index', [
            'links' => $links
        ])->header('Content-Type', 'text/xml');
    }
}
