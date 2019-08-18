<?php

namespace App\Http\Controllers;

use Request;
use Route;
use App\Traits\ComponentHandler;
use App\Page;
use App\Page_component;


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
            "article" => '' //9
        );

        $page_components = array();
        $menu_item_id= Route::current()->getName();

        if($menu_item_id === "article_single"){
            $components_content['article']= $this->Article($param1);
            $page_components[0]= array('component_id' => '9') ;
            return view('master')->with(['components_content' => $components_content, 'components' => $page_components]);
        }

        //ZIADNY CONTTENT
        if( ! Page::where('menu_item_id', $menu_item_id)->first() )
            return view('master')->with(['components' => null]);

        $page_id = Page::where('menu_item_id', $menu_item_id)->get()[0]->id;
        $page_components= Page_component::select('component_id')->where('page_id', $page_id)->orderBy('component_order')->get();

        foreach ($page_components as $key => $value) {
            
            if($value->component_id == $enum_components['carousel']){
                $components_content['carousel']= "";
            }
            if($value->component_id == $enum_components['introduction']){
                $components_content['introduction']= "";
            }
            if($value->component_id == $enum_components['about']){
                $components_content['about']= '';
            }
            if($value->component_id == $enum_components['news']){
                $components_content['news']= $this->News();
            }
            if($value->component_id == $enum_components['top_articles']){
                $components_content['top_articles']= $this->Top_articles();
            }
            if($value->component_id == $enum_components['map']){
                $components_content['map']= $this->Map();
            }
            if($value->component_id == $enum_components['gallery']){
                $components_content['gallery']= "";
            }
            if($value->component_id == $enum_components['articles']){
                $components_content['articles']= $this->Articles($param1,$param2);
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
