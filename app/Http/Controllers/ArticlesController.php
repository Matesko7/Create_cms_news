<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Auth;

class ArticlesController extends Controller
{
    public function index(){
        $article= new Article;
        $articles=$article->getAllwAuthorandGroup(3,date("Y-m-d H:i:s"));
        //return $articles;
        foreach ($articles as $key => $value) {
            $articles[$key]->photo=false;
            $photos= glob("articles/$value->id/*"); // get all file names
            foreach($photos as $photo){ // iterate files
                if(is_file($photo))
                    $articles[$key]->photo=$photo;
            }
        }
        return view('clanky',['articles' => $articles]);
    }

    public function article($id){
        $article= new Article;
        $article=$article->getArticlewAuthorandGroup($id);
        if($article[0]->audience==2){
            if(!isset(Auth::user()->email) || !Auth::user()->verified)
                return back()->with('warning','Tento článok je len pre prihlasených použivateľov. Ak si ho chcete prečítať prosim prihláste sa');
        }
        $article[0]->photo=false;
        $tags=explode("|",$article[0]->tags);
        $photos= glob("articles/$id/*"); // get all file names
        foreach($photos as $photo){ // iterate files
            if(is_file($photo))
                $article[0]->photo=$photo;
        }
        return view('clanok_detail',['article' => $article,'tags' =>$tags]);
    }
}
