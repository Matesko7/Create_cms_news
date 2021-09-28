<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Component;
use App\Page;
use App\Page_component;
use Illuminate\Support\Facades\DB;
use App\Component_detail;
use App\General_option;

class PagesController extends Controller
{
    public function edit($id = null){
        $components_about = Component_detail::where('id_component',3)->get();
        $components_gallery = Component_detail::where('id_component',7)->get();
        $components_map = Component_detail::where('id_component',6)->get();
        $components_articles = Component_detail::where('id_component',8)->get();
        $components_carousel = Component_detail::where('id_component',1)->get();
        $components_voting = Component_detail::where('id_component',11)->get();
        $pageStyle = General_option::where('type_id',9)->get();
        
        if(! Page::find($id)){
            return redirect('/admin/pages');
        }
        $page_name= Page::where('id', $id)->get()[0]->name;
        $page_components= DB::table('page_components')->where('page_id', $id)->join('components', 'page_components.component_id','components.id')->Leftjoin('component_details', 'page_components.component_detail_id','component_details.id')->select('page_components.id','components.name','component_details.name AS name2' )->orderBy('page_components.component_order')->get();

        return view('Admin/Pages/edit')->with(["components" => Component::all(),"components_about"=>$components_about,"components_gallery"=>$components_gallery,"components_map"=>$components_map, "components_carousel"=>$components_carousel, "components_voting"=>$components_voting,"page_name" => $page_name,"page_components" => $page_components,"components_articles" => $components_articles,"pageStyle" => $pageStyle[0]->value ,"id" => $id]);
    }

    public function index(){
        $menu_items= DB::select("SELECT * FROM admin_menu_items");
        return view('Admin/Pages/index2')->with(["menu_items" => $menu_items,"pages" => Page::all()]);
    }

    public function save(Request $request, $id){
        if($request->page_name == "")
            return redirect('/admin/pages')->with('error', 'Názov stránky nemože byť prázdny');
        if( Page::where('name',$request->page_name)->first())
            return redirect('/admin/pages')->with('error', 'Stránka s týmto názvom už existuje');
        if($id == "new"){
            DB::insert("INSERT INTO pages (name) VALUES ('$request->page_name')");
        }
        return redirect('/admin/pages');
    }
    
    public function deletePage($id){
        Page::where('id',$id)->delete();
        return redirect('/admin/pages')->with('success', 'Stránka bola úspešne zmazaná');
    }
    
    public function addMenuItemToPage($id_page, $id_menuItem){
        if( Page::where('menu_item_id',$id_menuItem)->first())
            return redirect('/admin/pages')->with('error', 'Jedna položka v menu( link) može byť priradená iba jednej stránke');
        Page::where('id',$id_page)->update(['menu_item_id' => $id_menuItem]);
        return redirect('/admin/pages')->with('success', 'Stránka bola úspešne priradená');
    }


    //AJAX
    public function saveComponent(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        //kontrola ci dany komponent na danej stranke uz existuje. Ak ano na jednej stranke moze max jeden
        if( Page_component::where('page_id',$request->page_id)->where('component_id',$request->component_id)->first()){
            $response['status']= 'error';
            $response['msg']= 'Tento komponent už na stránke existuje';
            return $response;
        }

        $order= Page_component::where('page_id', $request->page_id)->max('component_order');
        if($request->component_detail_id == "") $request->component_detail_id = 'null';
        if(DB::insert("INSERT INTO page_components (component_id,component_detail_id,page_id,component_order) VALUES ($request->component_id,$request->component_detail_id,'$request->page_id',$order+1)")){
            $response['status']= 'success';
            $response['msg']=  DB::getPdo()->lastInsertId();
        }
        
        return $response;
    }

    //AJAX
    public function deleteComponent(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        //kontrola ci dany komponent na danej stranke existuje
        if( ! Page_component::where('page_id',$request->page_id)->where('id',$request->component_id)->first()){
            $response['status']= 'error';
            $response['msg']= 'Tento komponent na stránke neexistuje';
            return $response;
        }

        if( Page_component::where('page_id',$request->page_id)->where('id',$request->component_id)->delete())
            $response['status']= 'success';

        $page_components = Page_component::where('page_id',$request->page_id)->orderBy('component_order')->get();

        foreach($page_components as $key => $component){
            $tmp = Page_component::where('id', $component->id)->update(['component_order' => ($key+1) ]);
        }

        
        return $response;
    }
    
    //AJAX
    public function changeOrderOfComponents(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        $tmp= explode("&",$request->order);

        foreach ($tmp as $key => $value) {
            $tmp2 =  explode("=",$value );
            Page_component::where('id', $tmp2[1])->update(['component_order' => ($key+1)]);
        }

        return $response;
    }
}
