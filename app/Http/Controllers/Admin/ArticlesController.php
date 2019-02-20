<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class ArticlesController extends Controller
{
    public function index(){
        $articles= new Article;
        return view('Admin/articles', ['articles' => $articles->getAll()]);
    }

    public function article(){
        $article= new Article;
        return view('Admin/articles', ['articles' => $article->getAll()]);
    }

    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }
}
