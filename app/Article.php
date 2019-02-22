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
        return $article = $this::where('id',$id)->get();
    }

    public function getCategoryByArticleId($id){
        return DB::select("SELECT category_id FROM articles LEFT JOIN categories ON articles.category_id=categories.id WHERE articles.id=:id",['id' => $id]);
    }

    public function update($title,$perex,$plot,$id=null){
        if($id==null){
            //novy clanok
        }
        else{
            //update clanku
            
        }
    }

    public function deleteArticle($id){
        $this::where('id',$id)->delete();
    }
}
