<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index(){
        if (isset(Auth::user()->email))
            return redirect('successlogin');   
        else 
            return view('login');   
    }

    public function checklogin(Request $request) {
        $this->validate($request, [
            'password' => 'required|min:5'
        ]);
      
        $user_data = array(
            'email' => $request->get('e-mail'),
            'password' => $request->get('password'),
        );

        if(Auth::attempt($user_data)){
            return redirect('successlogin');
        }
        else {
            return back()->with('error','Neplatné prihlasovacie údaje');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('login')->with('success','Odhlasenie prebehlo úspešne');
    }
}
