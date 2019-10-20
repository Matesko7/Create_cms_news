<?php

namespace App\Http\Controllers;

use Request;
use Route;
use App\Traits\ComponentHandler;
use App\Page;
use App\Page_component;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    use ComponentHandler;

    public function handle($param1 = null, $param2= null){
        //ciselniky
        $enum_components = config('global_var.enum_components');
        
        //CONTENT SEND to COMPONENTS
        $components_content = array( 
            "carousel" => '', //1
            "introduction" => '', //2 
            "about" => '', //3
            "news" => '', //4
            "top_articles" => '', //5 
            "map" => '', //6
            "gallery" => '', //7
            "articles" => '', //8
            "newsletter" => '', //9
            "article" => '', //single_article
        );


        $page_components = array();
        $menu_item_id= Route::current()->getName();
        
        
        if( strpos($menu_item_id,'article_single') !== false ){
            $components_content['article']= $this->Article($param1);

            if(isset($components_content['article']['warning']))
                return redirect('/')->with("warning", $components_content['article']['warning']);

            $page_components[0]= array('component_id' => 'single_article') ;
            $route_to_articles=explode("|",$menu_item_id)[1];
            return view('master')->with(['components_content' => $components_content, 'components' => $page_components, 'route_to_article' => $route_to_articles]);
        }

        if( $menu_item_id === "user" ){
            $components_content['articles']= $this->ArticlesPerUser($param1);
            if(isset($components_content['articles']['warning']))
                return redirect('/')->with("warning", $components_content['articles']['warning']);
            
            $page_components[0]= array('component_id' => 'user') ;
            return view('master')->with(['components_content' => $components_content, 'components' => $page_components]);
        }

        //ZIADNY CONTTENT
        if( ! Page::where('menu_item_id', $menu_item_id)->first())
            return view('master')->with(['components' => array()]);

        $page_id = Page::where('menu_item_id', $menu_item_id)->get()[0]->id;
        $page_components= Page_component::select('component_id','component_detail_id')->where('page_id', $page_id)->orderBy('component_order')->get();

        foreach ($page_components as $key => $value) {
            
            if($value->component_id == $enum_components['carousel']){
                $components_content['carousel']= DB::select("SELECT * FROM `component_details_carousel` WHERE id_component_detail = $value->component_detail_id ORDER BY image_order");
            }
            if($value->component_id == $enum_components['introduction']){
                $components_content['introduction']= "";
            }
            if($value->component_id == $enum_components['about']){
                $components_content['about']= DB::select("SELECT * FROM `component_details_about` WHERE id_component_detail = $value->component_detail_id");
            }
            if($value->component_id == $enum_components['news']){
                $components_content['news']= $this->News();
            }
            if($value->component_id == $enum_components['top_articles']){
                $components_content['top_articles']= $this->Top_articles();
            }
            if($value->component_id == $enum_components['map']){
                $map_detail = DB::select("SELECT * FROM `component_details_map` WHERE id_component_detail = $value->component_detail_id")[0];
                $components_content['map']= $this->Map($map_detail->latitude,$map_detail->longitude,$map_detail->text,$map_detail->link);
            }
            if($value->component_id == $enum_components['gallery']){
                $components_content['gallery']= DB::select("SELECT * FROM `component_details_gallery` WHERE id_component_detail = $value->component_detail_id ORDER BY image_order");
            }
            if($value->component_id == $enum_components['articles']){
                if($value->component_detail_id){
                    $articles_detail = DB::select("SELECT * FROM `component_details_articles` WHERE id_component_detail = $value->component_detail_id")[0];
                    $param1= $articles_detail->category_id;
                }
                $components_content['articles']= $this->Articles($param1,$param2);

                if($value->component_detail_id && isset($components_content['articles']['error'])){
                    $components_content['articles']= "";
                }
                
                if(isset($components_content['articles']['error']))
                    return redirect( route( Route::currentRouteName() ))->with('warning', $components_content['articles']['error']);
            }
            if($value->component_id == $enum_components['newsletter']){
                $components_content['newsletter']= "";
            }
        }

       //print_r($this->Article_index());   

        /*echo('linka: '. Request::path());
        echo('<br>menu_item_id: '. $menu_item_id );
        echo('<br>page_id: '. $menu_item_id. '<br>');
        print_r('page_components: '. $page_components );
        return;
        */

        
        return view('master')->with(['components_content' => $components_content, 'components' => $page_components]);
    }
}
