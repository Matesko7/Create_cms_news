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
        return view('Admin/users/index');
    }
}
