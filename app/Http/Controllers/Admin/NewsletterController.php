<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Newsletter_email;

class NewsletterController extends Controller
{
    public function index(){
        $emails = Newsletter_email::paginate(20);
        return view('Admin/Newsletter/index')->with('emails',$emails);
    }

    public function save(){
        $emailErr= "";
        $email= $_GET["email"];
        if (empty($email)) {
            $emailErr = "Nezadali ste email";
          } else {
            $email = $this->test_input($email);
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

    private function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
