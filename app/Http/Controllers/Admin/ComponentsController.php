<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Component;
use App\Component_detail;
use Illuminate\Support\Facades\DB;
use Auth;
use URL;

class ComponentsController extends Controller
{
    
    public function index(){
        $components=Component_detail::leftJoin('components', function($join){
            $join->on('component_details.id_component','=','components.id');
        })->select('components.name as type','component_details.name','component_details.id')->paginate(15);

        return view('Admin/Components/index')->with(['components' => $components]);
    }

    public function new(){
        return view('Admin/Components/new')->with(['components' => Component::all()]);
    }

    public function save(Request $request, $id = null){
        //new one
        if($id===null){
            $this->validate($request, [
                'name' => 'required',
                'component_type' => 'required',
            ]);

        $component = new Component_detail;
        $component->name = $request->name;
        $component->id_component = $request->component_type;
        $component->save();
        
        return redirect('/admin/components')->with('success', 'Nový komponent úspešne pridaný');
        }
    }

    public function edit($id){
        $enum_components = config('global_var.enum_components'); 
        $component= Component_detail::where('id',$id)->get();
        if($component[0]->id_component  == $enum_components['gallery']){
            $gallery= DB::select("SELECT * FROM component_details_gallery WHERE id_component_detail = $id ORDER BY image_order");
            return view('Admin/Components/edit_galery')->with(['gallery' => $gallery, 'component' => $component]);
        }
        if($component[0]->id_component  == $enum_components['about']){
            $component_content= DB::select("SELECT * FROM component_details_about WHERE id_component_detail = $id");
            return view('Admin/Components/edit_about')->with(['content' => $component_content, 'component' => $component]);
        }
        
        return back()->with('warning', 'Tento komponent sa nedá editovať');
    }

    public function delete($id){
        $id_component= Component_detail::where('id',$id)->select('id_component')->get()[0]->id_component;
        if($id_component == 3){
            $files= glob("about_component/$id/*"); // get all file names
            foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file);
            }   
            if (is_dir("about_component/$id")) {
                rmdir("about_component/$id");
            }
            DB::delete("DELETE FROM component_details_about WHERE id_component_detail=$id");
        }else if($id_component == 7){
            $files= glob("gallery_component/$id/*"); // get all file names
            foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file);
            }   
            if (is_dir("gallery_component/$id")) {
                rmdir("gallery_component/$id");
            }
            DB::delete("DELETE FROM component_details_gallery WHERE id_component_detail=$id");
        }
        
        Component_detail::where('id',$id)->delete();
        

        return back()->with('success', 'Komponent úspešne zmazaný');
    }

    public function rename(Request $request){
        $response= array("status" => "", "msg" => "" );
        if(!Component_detail::where('id',$request->component_id)->update(['name' => $request->new_name]))
            $response['msg']=  "Niečo sa pokazilo :/";
        return $response;
    }

    public function newImageToGallery(Request $request){
        
        if (!file_exists('gallery_component')) {
            mkdir('gallery_component', 0777, true);
        }

        if (!file_exists('gallery_component/'.$request->component_id)) {
            mkdir('gallery_component/'.$request->component_id, 0777, true);
        }

        $from=str_replace(URL::to('/').'/','',$request->src);
        $tmp= explode("/",$request->src); 
        $image_name= end($tmp);
        $to= 'gallery_component/'.$request->component_id.'/'.$image_name;


        $order= DB::select("SELECT max(image_order) AS poradie FROM component_details_gallery WHERE id_component_detail=$request->component_id")[0]->poradie;

        if(!$order) 
            $order=1;
        else
            $order++;
            
        DB::insert("INSERT INTO component_details_gallery (id_component_detail, link, image_order) VALUES ($request->component_id, '$to', $order)");

        copy($from,$to);

        return DB::getPdo()->lastInsertId();
    }

    public function editImage(Request $request){
        Auth::user()->authorizeRoles('admin','editor');
        
        if($request->action=="1"){//posun fotky do LAVA
            
            $photo= DB::select ('SELECT * FROM component_details_gallery WHERE id_component_detail=? AND id=?',[$request->id,$request->image_id]);

            //zistim ci som na zaciatku teda ci potrebujem prehodit prvu foto na posledne miesto
            $next_photo= DB::select ('SELECT * FROM component_details_gallery WHERE id_component_detail=? AND image_order=?',[$request->id,$photo[0]->image_order-1]);

            if(!empty($next_photo)){    
                DB::update('UPDATE component_details_gallery SET image_order=image_order-1  WHERE id_component_detail=? AND id=?',[$request->id,$photo[0]->id]);
                
                DB::update('UPDATE component_details_gallery SET image_order=image_order+1 WHERE id_component_detail=? AND id=?',[$request->id,$next_photo[0]->id]);
            }   
            else {
                $max_order=DB::select('SELECT MAX(image_order) as M FROM component_details_gallery WHERE id_component_detail=?',[$request->id]);
    
                DB::update('UPDATE component_details_gallery SET image_order='.$max_order[0]->M.' WHERE id_component_detail=? AND id=?',[$request->id,$photo[0]->id]);
    
                DB::update('UPDATE component_details_gallery SET image_order=image_order-1  WHERE id_component_detail=? AND id!=?',[$request->id,$photo[0]->id]);
            }
            
            $gallery= DB::select("SELECT * FROM component_details_gallery WHERE id_component_detail = $request->id ORDER BY image_order");
            return $gallery; 
        }
        if($request->action=="2"){ //zmazanie fotky

            $img=DB::select("SELECT * FROM component_details_gallery WHERE id=?",[$request->image_id])[0]->link;
            
            if (file_exists($img)) {
                unlink($img);
            }

            DB::delete("DELETE  FROM component_details_gallery WHERE id=?",[$request->image_id])[0];

            $images=DB::select('SELECT * from component_details_gallery WHERE id=? ORDER BY image_order',[$request->component_id]);
            
            foreach ($images as $key => $value) {
                DB::update('UPDATE component_details_gallery SET image_order='.($key+1).' WHERE id=? and image_id=?',[$request->component_id,$value->image_id]);
            }
            
            $gallery= DB::select("SELECT * FROM component_details_gallery WHERE id_component_detail = $request->id ORDER BY image_order");
            return $gallery; 
        }

        if($request->action=="3"){ //posun fotky do PRAVA
            
            $photo= DB::select ('SELECT * FROM component_details_gallery WHERE id_component_detail=? AND id=?',[$request->id,$request->image_id]);

            //zistim ci som na konci teda ci potrebujem prehodit poslednu foto na prve miesto
            $next_photo= DB::select ('SELECT * FROM component_details_gallery WHERE id_component_detail=? AND image_order=?',[$request->id,$photo[0]->image_order+1]);
            

            if(!empty($next_photo)){    
                DB::update('UPDATE component_details_gallery SET image_order=image_order+1  WHERE id_component_detail=? AND id=?',[$request->id,$photo[0]->id]);
                
                DB::update('UPDATE component_details_gallery SET image_order=image_order-1 WHERE id_component_detail=? AND id=?',[$request->id,$next_photo[0]->id]);
            }   
            else {
                DB::update('UPDATE component_details_gallery SET image_order=1 WHERE id_component_detail=? AND id=?',[$request->id,$photo[0]->id]);
    
                DB::update('UPDATE component_details_gallery SET image_order=image_order+1  WHERE id_component_detail=? AND id!=?',[$request->id,$photo[0]->id]);
            }
            
            $gallery= DB::select("SELECT * FROM component_details_gallery WHERE id_component_detail = $request->id ORDER BY image_order");
            return $gallery; 
        }
    }

    public function about(Request $request, $id){
        if (!file_exists('about_component')) {
            mkdir('about_component', 0777, true);
        }

        if (!file_exists('about_component/'.$id)) {
            mkdir('about_component/'.$id, 0777, true);
        }

        $link= false;
        if($file = $request->file('file')){
            if(isset($file)){
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $path = "about_component/".$id;
                $name = '1.' . $path_parts['extension'];
                $file->move($path,$name);
                $link = $path."/".$name;
            }
        }

        if(DB::select('SELECT * FROM component_details_about WHERE id_component_detail= ?',[$id])){
            $link=  $link ? $link : DB::select('SELECT * FROM component_details_about WHERE id_component_detail= ?',[$id])[0]->link; 
            DB::update('UPDATE component_details_about SET title= :title, text= :text, link= :link WHERE id_component_detail =:id',[
                "id" => $id,
                "title" => $request->title,
                "text" => $request->text,
                "link" => $link
            ]);      
        }else{
            $link=  $link ? $link : "" ;
            DB::insert("INSERT INTO  component_details_about (id_component_detail,title,text, link)  VALUES (:id,:title,:text,:link)", [
                "id" => $id, 
                "title" => $request->title,
                "text" => $request->text,
                "link" => $link
            ]);   
        }
        return redirect('/admin/components/edit/'.$id)->with('success', "Komponent úspešne uložený");
    }

}
