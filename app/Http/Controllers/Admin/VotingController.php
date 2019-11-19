<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Voting_option;
use Illuminate\Support\Facades\DB;
use Cookie;
use App\Voter;
use Request as Request2;

class VotingController extends Controller
{
    public function saveQuestion(Request $request, $id){ 
        
        $this->validate($request, [
            'question' => 'required'
        ]);

        if(DB::select('SELECT * FROM component_details_voting WHERE id_component_detail= ?',[$id])){
            DB::update('UPDATE component_details_voting SET question= :question, description= :description WHERE id_component_detail =:id',[
                "id" => $id,
                "question" => $request->question,
                "description" => $request->description
            ]);      
        }else{
            DB::insert("INSERT INTO  component_details_voting (id_component_detail,question,description)  VALUES (:id,:question,:description)", [
                "id" => $id,
                "question" => $request->question,
                "description" => $request->description
            ]);   
        }
        return redirect("/admin/components/edit/$id");
    }

    public function saveVote(){
        $id= $_GET["option"];
        $question_id= $_GET["question"];

        if(isset($_COOKIE['vote_question_'.$question_id]) || DB::select('SELECT * FROM voters WHERE question_id=? AND IPaddress= ? AND created_at > (NOW() - INTERVAL 5 MINUTE)',[$question_id,Request2::ip()]))
            return back()->with('warning', 'Ďakujeme, ale už ste hlasovali');

        if(!isset($_COOKIE['vote_question_'.$question_id])) {
            setcookie('vote_question_'.$question_id, 'true', time() + (86400 * 30), "/"); // 86400 = 1 day
        }

        if(!DB::select('SELECT * FROM voters WHERE question_id=? AND IPaddress= ?',[$question_id, Request2::ip()])){
            $voter = new Voter;
            $voter->question_id = $question_id;
            $voter->IPaddress = Request2::ip();
            $voter->save();
        }
        else
            Voter::where([ 'IPaddress' => Request2::ip(), 'question_id' => $question_id])->update(['created_at' => NOW()]);
            
        DB::update("UPDATE voting_options SET votes_number = votes_number + 1 WHERE id = $id");
        return back()->with('success', 'Ďakujeme za Váš hlas');
    }

    //AJAX
    public function saveOption(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        $order= Voting_option::where('id_question', $request->question_id)->max('option_order');
        if(DB::insert("INSERT INTO voting_options (id_question,value,option_order) VALUES ($request->question_id,'$request->value',$order+1)")){
            $response['status']= 'success';
            $response['msg']=  DB::getPdo()->lastInsertId();
        }
        return $response;
    }
    
    //AJAX
    public function deleteOption(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        //kontrola ci dany komponent na danej stranke existuje
        if( ! Voting_option::where('id',$request->option_id)->where('id_question',$request->question_id)->first()){
            $response['status']= 'error';
            $response['msg']= 'Snažíte sa vymazať možnosť ktorá neexistuje';
            return $response;
        }

        if(Voting_option::where('id',$request->option_id)->where('id_question',$request->question_id)->delete())
            $response['status']= 'success';

        $options = Voting_option::where('id_question',$request->question_id)->orderBy('option_order')->get();

        foreach($options as $key => $option){
            Voting_option::where('id', $option->id)->update(['option_order' => ($key+1)]);
        }
        
        return $response;
    }
        
    //AJAX
    public function changeOrderOfOptions(Request $request){ 
        $response= array("status" => "error", "msg" => "" );
        
        $tmp= explode("&",$request->order);

        foreach ($tmp as $key => $value) {
            $tmp2 =  explode("=",$value );
            Voting_option::where('id', $tmp2[1])->update(['option_order' => ($key+1)]);
        }

        return $response;
    }
}
