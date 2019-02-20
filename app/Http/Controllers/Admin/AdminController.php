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

    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }

    public function edit($id){
        return 123;
    }
}
