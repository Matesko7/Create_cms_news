<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Category;
use App\Comment;
use Auth;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    public function index($category=false,$tag=false){       
        $article= new Article;
        $category_param=false;
        $tag_param=false;

        if($category && $category!==0){
            $tmp=(integer)$this->makeSafe($category);
            if(is_integer($tmp)){
                $category_param=$tmp;
            }
        }
        if($tag && $tag !==0 ){
            $tag_param=$this->makeSafe($tag);
        }

        if($category_param && $tag_param){
            $articles=$article->getAllwAuthorandGroup(3,date("Y-m-d H:i:s"),$category_param,$tag_param);
        }
        else if($category_param)
            $articles=$article->x(3,date("Y-m-d H:i:s"),$category_param);
        else if($tag_param)
            $articles=$article->getAllwAuthorandGroup(3,date("Y-m-d H:i:s"),false,$tag_param);
        else{
            $articles=$article->getAllwAuthorandGroup(3,date("Y-m-d H:i:s"));
        }

        if(!count($articles)){
            return redirect(asset('/clanky'))->with('warning','Danému filtru nevyhovujú žiadne články');
        }
        
        $categories=Category::where('id','!=',1)->get();
        $tags= $article->getAllTags();

        foreach ($articles as $key => $value) {
            $articles[$key]->photo=false;
            $photos= glob("articles/$value->id/cover/*"); // get all file names
            foreach($photos as $photo){ // iterate files
                if(is_file($photo))
                    $articles[$key]->photo=$photo;
            }
        }

        return view('clanky',['articles' => $articles,'categories' => $categories, 'tags' => $tags, 'category' => $category_param, 'tag' =>$tag_param]);
    }

    public function article($id){
        echo(123);
        return;
        $article_tmp= new Article;
        $comments_tmp= new Comment;
        $article=$article_tmp->getArticlewAuthorandGroup($id);
        if($article[0]->audience==2){
            if(!isset(Auth::user()->email) || !Auth::user()->verified)
                return back()->with('warning','Tento článok je len pre prihlasených použivateľov. Ak si ho chcete prečítať prosim prihláste sa');
        }
        if($article[0]->audience_role_id){
            if(Auth::user()->email || !Auth::user()->verified)
                return back()->with('warning','Tento článok je len pre prihlasených použivateľov. Ak si ho chcete prečítať prosim prihláste sa');
        }


        $article[0]->photo=false;
        $tags=explode("|",$article[0]->tags);
        $photos= glob("articles/$id/cover/*"); // get all file names
        foreach($photos as $photo){ // iterate files
            if(is_file($photo))
                $article[0]->photo=$photo;
        }

        //$comments= json_decode(json_encode($comments_tmp->getAllComentswUserByArcticleId($id),true));
        $comments= $comments_tmp->getAllComentswUserByArcticleId($id);
        //$comments['child']= array();
        //print_r($comments);
        
        $tmp_comments_reply=$comments_tmp->getAllRepliesComentswUserByArcticleId($id);


        foreach ($comments as $key1 => $comment) {
            $tmp= array();
            foreach ($tmp_comments_reply as $key2 => $comment_reply) {
                if($comment->id == $comment_reply->parent_id){
                    $tmp2= array('userId' => $comment_reply->user_id,'userName' => $comment_reply->user_name,'created_at' => $comment_reply->created_at,'plot' => $comment_reply->comment);
                    array_push($tmp,$tmp2);
                    //$comments[$key]= $tmp;
                    //array_push($comments[2],$tmp);
                }
            }
            $comments[$key1]->child = $tmp;
        }
        $categories_all=Category::where('id','!=',1)->get();
        $tags_all= $article_tmp->getAllTags();
       
        $attachments= DB::select("SELECT * FROM article_attachment where article_id=$id");
        $related_articles= DB::select("SELECT * FROM aritcle_related A LEFT JOIN articles B on A.related_article_id=B.id where A.article_id=$id");
        $gallery= DB::select("SELECT * FROM article_image A LEFT JOIN  images B on A.image_id=B.id where A.article_id=$id");

        
        //KONTROLA NA PRAVA NA EDITOVANIE CLANKU
        $editor= false;
        if(Auth::check() && Auth::user()->hasRole('editor')){
            $result = Article::where(['id' => $id, 'user_id' => Auth::user()->id])->get();
            if (!$result->isEmpty())
                $editor= true;
        }

        if(Auth::check() && Auth::user()->hasRole('admin'))
                $editor= true;


        return view('clanok_detail',['article' => $article,'tags' =>$tags,'tags_all' => $tags_all, 'categories_all' => $categories_all,'comments' => $comments,'attachments' => $attachments,'gallery' => $gallery,'related_articles' => $related_articles, 'editor' => $editor]);
    }

    private function makeSafe($file) {
        $file = rtrim($file, '.');
        $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
        return trim(preg_replace($regex, '', $file));
    }
}
