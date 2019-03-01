<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class ArticlesController extends Controller
{
    public function index(){
        $articles= new Article;
        return view('Admin/Articles/articles', ['articles' => $articles->getAllwAuthorandGroup()]);
    }

    public function edit($id=null){
        $article= new Article;
        $category= new Category;
        $categories= Category::all();
        if($id!=null){
            $article_category=$article->getCategoryByArticleId($id);
            if(!$article_category)
                $article_category=1; //nezaradene
            $articles=$article->getArticle($id);
            $tags= explode("|",$articles[0]->tags);
            return view('Admin/Articles/article_detail', ['article' => $article->getArticle($id),'categories' => $categories,'article_category' => $article_category,'tags'=> $tags]);
        }
        else{
            return view('Admin/Articles/article_new',['categories' => $categories]);
        }
    }

    public function save(Request $request,$id=null){
        $this->validate($request, [
            'title' => 'required',
            'perex' => 'required',
            'plot' => 'required',
        ]);

        $tmp_tags="";
        if(!empty($request->tags)){
            foreach($request->tags as $key=>$tag){
                if($key==0)
                    $tmp_tags=$tag;
                else 
                    $tmp_tags=$tmp_tags."|".$tag;
            };
        }
        if(empty($request->category))
            $request->category=array(1);
        $article= new Article;
        if($id==null){
            $article->updateArticle($request->title,$request->perex,$request->plot,$tmp_tags,$request->category[count($request->category)-1],$request->audience,Auth::user()->id);
            return back()->with('success','Článok pridaný');
        }
        else{
            $article->updateArticle($request->title,$request->perex,$request->plot,$tmp_tags,$request->category[count($request->category)-1],$request->audience,$request->user_id,$id);
            return back()->with('success','Článok aktualizovaný');
        }
    }


    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }
}
