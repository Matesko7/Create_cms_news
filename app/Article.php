<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public function getAll(){
        return $articles = $this::paginate(15);
    }

    public function getArticle($id){
        if($this::where('id',$id)->first())
            return $article = $this::where('id',$id)->get();
    }

    public function deleteArticle($id){
        $this::where('id',$id)->delete();
    }
}
