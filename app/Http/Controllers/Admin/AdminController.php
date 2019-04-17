<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\User;
use Auth;

class AdminController extends Controller
{
    public function index(){
        $user_photo=false;
        $photo= glob("users/".Auth::user()->id."/*"); // get all file names
        foreach($photo as $value){ // iterate files
            if(is_file($value))
                $user_photo=$value;
        }  
        return view('Admin/Users/index',['user_photo' => $user_photo]);
    }
}
