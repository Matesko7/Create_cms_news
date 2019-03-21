<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

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

    public function getAllwAuthorandGroup($paginate=15,$date='2030-01-01 00:00:00'){
        return $this::leftJoin('categories', function($join){
            $join->on('articles.category_id','=','categories.id');
        })
        ->leftJoin('users', function($join2){
            $join2->on('articles.user_id','=','users.id');
        })
        ->select('categories.name as cat_name', 'users.name as user_name', 'articles.*')
        ->where('articles.created_at','<',$date)
        ->orderBy('articles.created_at', 'desc')
        ->paginate($paginate);

        //DB::select("SELECT *,categories.name as cat_name,users.name as user_name FROM articles LEFT JOIN categories ON articles.category_id=categories.id LEFT JOIN users ON articles.user_id=users.id");
    }

    public function getPerEditorwAuthorandGroup(){
        return $this::leftJoin('categories', function($join){
            $join->on('articles.category_id','=','categories.id');
        })
        ->leftJoin('users', function($join2){
            $join2->on('articles.user_id','=','users.id');
        })
        ->select('categories.name as cat_name', 'users.name as user_name', 'articles.*')
        ->where('articles.user_id',Auth::user()->id)
        ->orderBy('articles.created_at', 'desc')
        ->paginate(15);
    }

    public function getArticlewAuthorandGroup($id){
        return $this::leftJoin('categories', function($join){
            $join->on('articles.category_id','=','categories.id');
        })
        ->leftJoin('users', function($join2){
            $join2->on('articles.user_id','=','users.id');
        })
        ->select('categories.name as cat_name', 'users.name as user_name', 'articles.*')
        ->where('articles.id',$id)
        ->get();
    }

    public function updateArticle($title,$perex,$plot,$tags,$category,$audience,$user_id,$dateArticle,$id=null){
        if($id==null){
            DB::insert("INSERT INTO `articles` (`plot`, `title`, `category_id`, `perex`, `user_id`, `tags`, `audience`,`created_at`,`updated_at`) VALUES (:plot,:title,:category,:perex,:user,:tags,:audience,:created,:updated)",[
                'plot' => $plot,
                'title' => $title,
                'category' => $category,
                'perex' => $perex,
                'tags' => $tags,
                'audience' => $audience,
                'user' => $user_id,
                'created' => $dateArticle,
                'updated' => date("Y-m-d H:i:s")
                ]);
            return DB::getPdo()->lastInsertId();  
        }
        else{
            DB::update("UPDATE `articles` SET `plot`=:plot,`title`=:title,`category_id`=:category,`perex`=:perex,`tags`=:tags,`audience`=:audience,`user_id`=:user,`created_at`=:created WHERE id=:id",[
            'plot' => $plot,
            'title' => $title,
            'category' => $category,
            'perex' => $perex,
            'tags' => $tags,
            'audience' => $audience,
            'user' => $user_id,
            'id' => $id,
            'created' => $dateArticle
            ]);
        }
    }

    public function deleteArticle($id){
        $this::where('id',$id)->delete();
    }
}
