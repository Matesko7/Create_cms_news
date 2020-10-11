<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\General_option;
use App\General_options_type;
use Illuminate\Support\Facades\DB;

class OptionsController extends Controller
{
    public function index(){
        $options= DB::select("SELECT A.id,A.value,A.type_id,B.name FROM general_options as A LEFT JOIN general_options_types as B ON A.type_id =B.id");
        return view('Admin/Options/index', ['options' => $options]);
    }

    public function delete($id){
        General_option::where('id',$id)->delete();  
        return redirect('admin/options')->with(['success' => 'Nastavenie úspešne zmazané']);
    }

    public function edit($id=null){
        if($id==null){
            return view('Admin/Options/option',['options' => General_options_type::all()]);    
        }
        else{
            $option= General_option::where('id',$id)->get()[0];           
            return view('Admin/Options/option', ['option' => $option,'options' => General_options_type::all()]);
        }
    }

    public function save(Request $request,$id=null){
        
        if($request->options_type == 7 and !is_numeric($request->option_value1)){
            return back()->with('warning','Tento typ parametra môže obsahovať len číselne hodnoty');
        }

        if($id==null){
            $option = new General_option;
            if($request->options_type == 4){
                $value= $request->meta_options_type."||". $request->option_value."||".$request->option_value_content;
            }
            else if($request->options_type == 8){
                $value= "rel||". $request->option_value."||".$request->option_value_content;
            }
            else if($request->options_type == 6){
                $value= $request->email."||".$request->email_alias;
            }
            else{
                if(General_option::where('type_id',$request->options_type)->first())
                    return back()->with('warning','Nastavenie pre tento typ parametra môže byť len jedno');
                $value= $request->option_value1;
            }

            $option->type_id = $request->options_type;
            $option->value = $value;
            $option->save();
            return redirect(asset("admin/options"))->with('success','Nastavenie pridané');
        }
        else{
            if($request->options_type == 4)
                $value= $request->meta_options_type."||".$request->option_value."||".$request->option_value_content;
            else if($request->options_type == 6)
                $value= $request->email."||".$request->email_alias;
            else 
                $value= $request->option_value1;

            General_option::where('id',$id)->update(['type_id' => $request->options_type, 'value' => $value]);  
            return back()->with('success','Nastavenie aktualizované');
        }
    }
}
