<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Component;
use App\Page;
use App\Page_component;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function edit($id = null){
        $menu_items= DB::select("SELECT * FROM admin_menu_items");
        if(!$id){
            return view('Admin/Pages/index')->with(["components" => Component::all(),"pages" => Page::all(),"menu_items" => $menu_items,"id" => null]);
        }
        else{
            if(! Page::find($id))
                return redirect('/admin/pages');
            
            $page_name= Page::where('id', $id)->get()[0]->name;
            $page_components= DB::table('page_components')->where('page_id', $id)->join('components', 'page_components.component_id','components.id')->orderBy('page_components.component_order') -> get();
        
            return view('Admin/Pages/index')->with(["components" => Component::all(),"pages" => Page::all(),"page_name" => $page_name,"page_components" => $page_components,"menu_items" => $menu_items,"id" => $id]);
        }
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
        if(DB::insert("INSERT INTO page_components (component_id,page_id,component_order) VALUES ('$request->component_id','$request->page_id',$order+1)"))
            $response['status']= 'success';
        
        return $response;
    }

    //AJAX
    public function deleteComponent(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        //kontrola ci dany komponent na danej stranke existuje
        if( ! Page_component::where('page_id',$request->page_id)->where('component_id',$request->component_id)->first()){
            $response['status']= 'error';
            $response['msg']= 'Tento komponent na stránke neexistuje';
            return $response;
        }

        if( Page_component::where('page_id',$request->page_id)->where('component_id',$request->component_id)->delete())
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
            Page_component::where('component_id', $tmp2[1])->update(['component_order' => ($key+1)]);
        }

        return $response;
    }
}
