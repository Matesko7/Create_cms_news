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
        
        if(Auth::user()->hasRole('admin'))
            $articles=$articles->getAllwAuthorandGroup();
        if(Auth::user()->hasRole('editor'))
            $articles=$articles->getPerEditorwAuthorandGroup();

        return view('Admin/Articles/articles', ['articles' => $articles]);
    }

    public function edit($id=null){
        $article= new Article;
        $category= new Category;
        $categories= $category->getAll();
        $article_photo=false;
        if($id!=null){
            $article_category=$article->getCategoryByArticleId($id);
            if(!$article_category)
                $article_category=1; //nezaradene
            $articles=$article->getArticle($id);
            $tags= explode("|",$articles[0]->tags);

            $photos= glob("articles/$id/*"); // get all file names
            foreach($photos as $value){ // iterate files
                if(is_file($value))
                    $article_photo=$value;
            }  
            return view('Admin/Articles/article_detail', ['article' => $article->getArticle($id),'categories' => $categories,'article_category' => $article_category,'tags'=> $tags,'article_photo' => $article_photo]);
        }
        else{
            return view('Admin/Articles/article_new',['categories' => $categories,'article_photo' => $article_photo]);
        }
    }

    public function save(Request $request,$id=null){
        $this->validate($request, [
            'title' => 'required',
            'perex' => 'required',
            'editor' => 'required',
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
        if($request->dateArticle=="okamžite")
            $request->dateArticle=date("Y-m-d H:i:s");
        else{
            $tmp=explode("/",$request->dateArticle);
            $request->dateArticle=$tmp[2].'-'.$tmp[0].'-'.$tmp[1].' 00:00:00' ;
        } 

 


        if($id==null){
            $id_new_article=$article->updateArticle($request->title,$request->perex,str_replace(array("\n","\r","&#9;"),array("","",""),$request->editor),$tmp_tags,$request->category[count($request->category)-1],$request->audience,Auth::user()->id,$request->dateArticle);
            //ulozenie nahrateho suboru
            $file = $request->file('file');
            if(isset($file)){
                $photos= glob("articles/$id_new_article/*"); // get all file names
                foreach($photos as $value){ // iterate files
                    if(is_file($value))
                        unlink($value);
                }
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $size= $_FILES['file']['size'];
                $file->move(base_path('public/articles/'.$id_new_article),'cover_photo.'.$path_parts['extension']);
            }

            return redirect(asset("admin/article/$id_new_article"))->with('success','Článok pridaný');
        }
        else{
            //ulozenie nahrateho suboru
            $file = $request->file('file');
            if(isset($file)){
                $photos= glob("articles/$id/*"); // get all file names
                foreach($photos as $value){ // iterate files
                    if(is_file($value))
                        unlink($value);
                }
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $size= $_FILES['file']['size'];
                $file->move(base_path('public/articles/'.$id),'cover_photo.'.$path_parts['extension']);
            }

            $article->updateArticle($request->title,$request->perex,str_replace(array("\n","\r","&#9;"),array("","",""),$request->editor),$tmp_tags,$request->category[count($request->category)-1],$request->audience,$request->user_id,$request->dateArticle,$id);
            return back()->with('success','Článok aktualizovaný');
        }
    }


    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        $photos= glob("articles/$id/*"); // get all file names
        foreach($photos as $value){ // iterate files
            if(is_file($value))
                unlink($value);
        }
        if (is_dir("articles/$id")) {
            rmdir("articles/$id");
        }
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }
}
