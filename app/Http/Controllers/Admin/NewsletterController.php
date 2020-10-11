<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Newsletter_email;
use Mail;
use App\Email;
use GuzzleHttp\Client;
use App\General_option;

class NewsletterController extends Controller
{
    public function index(){
        $subscribers = Newsletter_email::paginate(20);
        $subscribers_numbers= [];
        $subscribers_numbers['active']= Newsletter_email::where('subscribe',1)->count();
        $subscribers_numbers['inActive']= Newsletter_email::where('subscribe',0)->count();
        $subscribers_numbers['all']= Newsletter_email::all()->count();
        $emails = Email::paginate(20);
        
        return view('Admin/Newsletter/index')->with(['subscribers' => $subscribers, 'subscribers_numbers' => $subscribers_numbers, 'emails' => $emails]);
    }

    public function saveSubscriber(){
        $emailErr= "";
        $email= $_GET["email"];
        if (empty($email)) {
            $emailErr = "Nezadali ste email";
          } else {
            $email = $this->clear_input($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $emailErr = "Neplatný formát emailu";
            }
          }
        if(Newsletter_email::where('email',$email)->first())
          $emailErr = "Ďakujeme, ale vás email už bol zaregistrovaný";

        if( $emailErr !== "")
          return back()->with('warning', $emailErr);  

        // MAILCHIMP 
        $url="https://us5.api.mailchimp.com/3.0/lists/e44555220f/members/";          
        try{
            
          $client = new Client([
            'auth' => [
              env('MAILCHIMP_USER'), 
              env('MAILCHIMP_API_KEY')
            ],
              'headers' => ['Content-Type' => 'application/json']
          ]);

          $body="{
            'email_address': '$email',
            'status': 'subscribed'
          }";  
          $body=str_replace("'",'"',$body);
          $response = $client->post($url, 
                  ['body' => $body]
          );
          
          $response = json_decode($response->getBody(), true);
          DB::insert("INSERT INTO newsletter_emails (email) VALUES ('$email')");
          return back()->with('success', 'Boli ste úspešne zaradený do newslettera');
        } catch(\Exception $e) {
            return back()->with('warning', 'Ospravedňujeme sa, ale niekde nastala chyba. Skúste neskor'); 
        }

        // if( DB::insert("INSERT INTO newsletter_emails (email) VALUES ('$email')") )
        //   return back()->with('success', 'Boli ste úspešne zaradený do newslettera');
    }

    public function sendEmail($id){

      $email = Email::where('id',$id)->get()[0];
      $email_subject= $email->subject;
      $email_adresses= Newsletter_email::where('subscribe','1')->get();
      $secret = config('global_var.secret');

      $from="admin@test.sk";
      $alias="Admin";

      if( $email_from = General_option::where('type_id',6)->first()){
        $from= explode('||', $email_from->value)[0];
        $alias=explode('||', $email_from->value)[1];
      }


      if($email_adresses){
        foreach ($email_adresses as $key => $address) {
          $email_subcriber= $address->email;
          $data = array('obsah'=> $email->body,'user_id' => $address->id, 'unsubscribe' => MD5($secret.$address->id));
          Mail::send('mail', $data, function($message) use ($email_subject,$email_subcriber, $from, $alias) {
            //$message->to($email_adress)->subject($email_subject);
            $message->bcc($email_subcriber)->subject($email_subject);
            $message->from($from,$alias);
          });     
        }
      }

      return back()->with('success', 'Email rozposlaný');
    }

    public function sendTestEmail(Request $request){

      $email = Email::where('id',$request->email_id)->get()[0];
      $email_subject= $email->subject;
      
      $from="admin@test.sk";
      $alias="Admin";

      if( $email_from = General_option::where('type_id',6)->first()){
        $from= explode('||', $email_from->value)[0];
        $alias=explode('||', $email_from->value)[1];
      }

      if($request->email){
        $email_subcriber= $request->email;
        $data = array('obsah'=> $email->body,'user_id' => "00", 'unsubscribe' => MD5("00"));
        Mail::send('mail', $data, function($message) use ($email_subject,$email_subcriber, $from, $alias) {
          //$message->to($email_adress)->subject($email_subject);
          $message->bcc($email_subcriber)->subject($email_subject);
          $message->from($from,$alias);
        });
      }
    }

    public function deleteSubscriber($id){

    //    MAILCHIMP 
      $hash= MD5(Newsletter_email::where('id',$id)->get()[0]->email);
      $url="https://us5.api.mailchimp.com/3.0/lists/e44555220f/members/$hash";          
      try{
        $client = new Client([
          'auth' => [
            env('MAILCHIMP_USER'), 
            env('MAILCHIMP_API_KEY')
          ],
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $body="{
          'status': 'unsubscribed'
        }";  

        $body=str_replace("'",'"',$body);

        $response = $client->patch($url, 
                ['body' => $body]
        );
        $response = json_decode($response->getBody(), true);
        Newsletter_email::where('id',$id)->update(['subscribe' => 0]);
        return back()->with('success', 'Odber pre použivateľa zrušený');
      } catch(\Exception $e) {
        return back()->with('error', 'Ups, niečo sa pokazilo :/ ');
      }

    //   if( Newsletter_email::where('id',$id)->update(['subscribe' => 0]) )
    //       return back()->with('success', 'Odber pre použivateľa zrušený');
     
    }

    public function refreshSubscriber($id){
      //  MAILCHIMP 
      $hash= MD5(Newsletter_email::where('id',$id)->get()[0]->email);

      $url="https://us5.api.mailchimp.com/3.0/lists/e44555220f/members/$hash";          
      try{
        $client = new Client([
          'auth' => [
            env('MAILCHIMP_USER'), 
            env('MAILCHIMP_API_KEY')
          ],
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $body="{
          'status': 'subscribed'
        }";  

        $body=str_replace("'",'"',$body);

        $response = $client->patch($url, 
                ['body' => $body]
        );
        $response = json_decode($response->getBody(), true);
        Newsletter_email::where('id',$id)->update(['subscribe' => 1]);
        return back()->with('success', 'Odber pre použivateľa obnovený');
      } catch(\Exception $e) {
        return back()->with('error', 'Ups, niečo sa pokazilo :/ ');
      }

    //   if( Newsletter_email::where('id',$id)->update(['subscribe' => 1]) )
    //     return back()->with('success', 'Odber pre použivateľa obnovený');

      
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
        'editor' => 'required',
      ]);

      $plot=str_replace(array("\n","\r","&#9;"),array("","",""),$request->editor);
      
      if($id){
        Email::where('id',$id)->update(['subject' => $request->subject, 'body' => $plot]);
        return redirect('admin/email/'.$id)->with('success','Uloženie emailu prebehlo úspešne');
      }
      else{
        $email= new Email;
        $email->subject=$request->subject;
        $email->body=$plot;
        $email->save();
        return redirect('admin/email/'.$email->id)->with('success','Uloženie emailu prebehlo úspešne');
      }
    }

    public function unsubscribe($id,$hash){
      if(!$id || !$hash)
        return;
      
      $secret = config('global_var.secret');
      $expected = MD5($secret.$id);

      if($id == "00" || $hash="b4b147bc522828731f1a016bfa72c073")
        return redirect('/')->with('success', 'Nasimuvalovanie odhlásenie z odberu prebehlo úspešne pre testovací email');

      if($expected != $hash)
        return redirect('/')->with('error', 'Pri odhlasovaní z odberu sa vyskytla chyba');

      
      $hash= MD5(Newsletter_email::where('id',$id)->get()[0]->email);
      $url="https://us5.api.mailchimp.com/3.0/lists/e44555220f/members/$hash";          
      try{
        $client = new Client([
          'auth' => [
            env('MAILCHIMP_USER'), 
            env('MAILCHIMP_API_KEY')
          ],
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $body="{
          'status': 'unsubscribed'
        }";  

        $body=str_replace("'",'"',$body);

        $response = $client->patch($url, 
                ['body' => $body]
        );
        $response = json_decode($response->getBody(), true);
        Newsletter_email::where('id',$id)->update(['subscribe' => 0]);
        return redirect('/')->with('success', 'Vaše odhlásenie z odberu prebehlo úspešne');
      } catch(\Exception $e) {
        return redirect('/')->with('error', 'Pri odhlasovaní z odberu sa vyskytla chyba');
      }

    //   if(Newsletter_email::where('id',$id)->update(['subscribe' => 0]) )
    //     return redirect('/')->with('success', 'Vaše odhlásenie z odberu prebehlo úspešne');
      
      
  }

    private function clear_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtolower($data);
        return $data;
    }
}
