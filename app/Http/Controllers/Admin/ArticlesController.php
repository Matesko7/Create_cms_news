<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Category;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    public function index(){
        $articles= new Article;
        return view('Admin/articles', ['articles' => $articles->getAll()]);
    }

    public function edit($id){
        $article= new Article;
        $category= new Category;
        //return $article->getArticle($id);
        $categories= Category::all();
        $article_category=$article->getCategoryByArticleId($id);
        if(!$article_category)
            $article_category=1; //nezaradene
        return view('Admin/article_detail', ['article' => $article->getArticle($id),'categories' => $categories,'article_category' => $article_category]);
    }

    public function save(Request $request,$id=null){
        $article= new Article;
        return "Touto cestou sa ulozi clanok pri dalsej verzii";
        if($id==null){
            //novy clanok

        }
        else{
            $article->updateArticle($request->title,$request->perex,$request->plot,$id);
            //zistenie tagov
            /*for ($i = 1; $i <= 10; $i++) {
                echo($request->tag1);
            }*/
            //$request->title
            //$request->perex
            //$request->plot

            //ulozenie editacie


        }
    }


    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }
}
