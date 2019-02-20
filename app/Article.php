<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public function getAll(){
        return $articles = Article::paginate(15);
    }

    public function deleteArticle($id){
        Article::where('id',$id)->delete();
    }
}
