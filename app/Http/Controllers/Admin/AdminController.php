<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class AdminController extends Controller
{
    public function index(){
        $articles= new Article;
        return view('Admin/admin', ['articles' => $articles->getAll()]);
    }
}
