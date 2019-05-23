<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Category;
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
            $articles=$article->getAllwAuthorandGroup(3,date("Y-m-d H:i:s"),$category_param);
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
        $article_tmp= new Article;
        $article=$article_tmp->getArticlewAuthorandGroup($id);
        if($article[0]->audience==2){
            if(!isset(Auth::user()->email) || !Auth::user()->verified)
                return back()->with('warning','Tento článok je len pre prihlasených použivateľov. Ak si ho chcete prečítať prosim prihláste sa');
        }
        $article[0]->photo=false;
        $tags=explode("|",$article[0]->tags);
        $photos= glob("articles/$id/cover/*"); // get all file names
        foreach($photos as $photo){ // iterate files
            if(is_file($photo))
                $article[0]->photo=$photo;
        }

        $categories_all=Category::where('id','!=',1)->get();
        $tags_all= $article_tmp->getAllTags();
       
        return view('clanok_detail',['article' => $article,'tags' =>$tags,'tags_all' => $tags_all, 'categories_all' => $categories_all]);
    }

    private function makeSafe($file) {
        $file = rtrim($file, '.');
        $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
        return trim(preg_replace($regex, '', $file));
    }
}
