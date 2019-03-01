<?php
namespace App\Http\Controllers;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mail;

class FeedbackController extends Controller
{
    public function send(FeedbackRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;
        $this->sendemail($name,$email,$message);
        return back()->with([
            'success' => 'Ďakujeme za vyplnenie formulára'
        ]);
    }   

    private function sendemail($name,$email,$text) {
        $data = array('text'=> $text,'email'=> $email,'name'=> $name);
        Mail::send('Email/email_form', $data, function($message){
            $message->to('svec@dynatech.sk')->subject('Formulár z webu');
            //$message->to('info@kmuctovnictvo.sk')->subject('Formulár z webu');
            $message->from('info@kmuctovnictvo.sk','KM WEB');
        });     
    }
}