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

    public function getAllwAuthorandGroup(){
        return $this::leftJoin('categories', function($join){
            $join->on('articles.category_id','=','categories.id');
        })
        ->leftJoin('users', function($join2){
            $join2->on('articles.user_id','=','users.id');
        })
        ->select('categories.name as cat_name', 'users.name as user_name', 'articles.*')
        ->paginate(15);

        DB::select("SELECT *,categories.name as cat_name,users.name as user_name FROM articles LEFT JOIN categories ON articles.category_id=categories.id LEFT JOIN users ON articles.user_id=users.id");
    }

    public function updateArticle($title,$perex,$plot,$tags,$category,$audience,$user_id,$id=null){
        if($id==null){
            DB::insert("INSERT INTO `articles` (`plot`, `title`, `category_id`, `perex`, `user_id`, `tags`, `audience`,`created_at`,`updated_at`) VALUES (:plot,:title,:category,:perex,:user,:tags,:audience,:created,:updated)",[
                'plot' => $plot,
                'title' => $title,
                'category' => $category,
                'perex' => $perex,
                'tags' => $tags,
                'audience' => $audience,
                'user' => $user_id,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
                ]);
        }
        else{
            DB::update("UPDATE `articles` SET `plot`=:plot,`title`=:title,`category_id`=:category,`perex`=:perex,`tags`=:tags,`audience`=:audience,`user_id`=:user,`updated_at`=:updated WHERE id=:id",[
            'plot' => $plot,
            'title' => $title,
            'category' => $category,
            'perex' => $perex,
            'tags' => $tags,
            'audience' => $audience,
            'user' => $user_id,
            'id' => $id,
            'updated' => date("Y-m-d H:i:s")
            ]);
        }
    }

    public function deleteArticle($id){
        $this::where('id',$id)->delete();
    }
}
