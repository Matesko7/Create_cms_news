<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Newsletter_email;
use Mail;
use App\Email;

class NewsletterController extends Controller
{
    public function index(){
        $subscribers = Newsletter_email::paginate(20);
        $emails = Email::paginate(20);
        return view('Admin/Newsletter/index')->with(['subscribers' => $subscribers, 'emails' => $emails]);
    }

    public function save(){
        $emailErr= "";
        $email= $_GET["email"];
        if (empty($email)) {
            $emailErr = "Nezadali ste email";
          } else {
            $email = $this->clean_input($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $emailErr = "Neplatný formát emailu";
            }
          }
        if(Newsletter_email::where('email',$email)->first())
          $emailErr = "Ďakujeme, ale vás email už bol zaregistrovaný";

        if( $emailErr !== "")
            return back()->with('warning', $emailErr);

        DB::insert("INSERT INTO newsletter_emails (email) VALUES ('$email')");
        return back()->with('success', 'Boli ste úspešne zaradený do newslettera');
    }

    public function sendEmail($id){

      $email = Email::where('id',$id)->get()[0];
      $data = array('obsah'=> $email->body);
      $email_subject= $email->subject;

      $emails=[];
      $email_adresses= Newsletter_email::where('subscribe','1')->get();
      if($email_adresses){
        foreach ($email_adresses as $key => $address) {
          array_push($emails,$address->email);
        }
      }

      Mail::send('mail', $data, function($message) use ($email_subject,$emails) {
        //$message->to($email_adress)->subject($email_subject);
        $message->bcc($emails)->subject($email_subject);
        $message->from('test@test.sk','Test');
      });     
    return back()->with('success', 'Email rozposlaný');
    }

    public function deleteSubscriber($id){
      Newsletter_email::where('id',$id)->delete();
      return back()->with('success', 'Email vymazaný zo zoznamu');
    }

    public function deleteEmail($id){
      Email::where('id',$id)->delete();
      return back()->with('success', 'Email vymazaný zo zoznamu');
    }

    public function email($id= null){
      $email="";
      if($id){
        $email=Email::where('id',$id)->get()[0];
      }
      return view('Admin/Newsletter/email')->with('email',$email);
    }

    public function saveEmail(Request $request, $id= null){
      
      $this->validate($request, [
        'subject' => 'required',
        'body' => 'required',
      ]);
      if($id){
        Email::where('id',$id)->update(['subject' => $request->subject, 'body' => $request->body]);
        return redirect('admin/email/'.$id)->with('success','Uloženie emailu prebehlo úspešne');
      }
      else{
        $email= new Email;
        $email->subject=$request->subject;
        $email->body=$request->body;
        $email->save();
        return redirect('admin/email/'.$email->id)->with('success','Uloženie emailu prebehlo úspešne');
      }
    }

    private function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
