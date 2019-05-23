<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Article extends Model
{
    public function articles() {
        return $this->belongsToMany(Image::class);
    }

    public function getAll(){
        return $articles = $this::paginate(15);
    }

    public function getArticle($id){
        return $article = $this::where('id',$id)->get();
    }

    public function getAllTags(){
            $tags= array();
            $tmp=$this::select('tags')->get();
            foreach ($tmp as $key => $value) {
                $tmp2=explode("|",$value->tags);
                foreach ($tmp2 as $key2 => $value2) {
                    if($value2!='')
                        array_push($tags,$value2);
                }
            }
            return $tags;
    }

    public function getCategoryByArticleId($id){
        return DB::select("SELECT category_id FROM articles LEFT JOIN categories ON articles.category_id=categories.id WHERE articles.id=:id",['id' => $id]);
    }

    public function getAllwAuthorandGroup($paginate=15,$date='2030-01-01 00:00:00',$category=false,$tag=false){

        if($category && $tag){
            $result= $this::leftJoin('categories', function($join){
                $join->on('articles.category_id','=','categories.id');
            })
            ->leftJoin('users', function($join2){
                $join2->on('articles.user_id','=','users.id');
            })
            ->select('categories.name as cat_name','categories.name_en as cat_name_en', 'users.name as user_name', 'articles.*')
            ->where('articles.created_at','<',$date)
            ->where('category_id','=',$category)
            ->where('tags','LIKE','%'.$tag.'%')
            ->orderBy('articles.created_at', 'desc')
            ->paginate($paginate);
        }
        else if($category){
            $result= $this::leftJoin('categories', function($join){
                $join->on('articles.category_id','=','categories.id');
            })
            ->leftJoin('users', function($join2){
                $join2->on('articles.user_id','=','users.id');
            })
            ->select('categories.name as cat_name','categories.name_en as cat_name_en', 'users.name as user_name', 'articles.*')
            ->where('articles.created_at','<',$date)
            ->where('category_id','=',$category)
            ->orderBy('articles.created_at', 'desc')
            ->paginate($paginate);
        }
        else if($tag){
            $result= $this::leftJoin('categories', function($join){
                $join->on('articles.category_id','=','categories.id');
            })
            ->leftJoin('users', function($join2){
                $join2->on('articles.user_id','=','users.id');
            })
            ->select('categories.name as cat_name','categories.name_en as cat_name_en', 'users.name as user_name', 'articles.*')
            ->where('articles.created_at','<',$date)
            ->where('tags','LIKE','%'.$tag.'%')
            ->orderBy('articles.created_at', 'desc')
            ->paginate($paginate);
        }
        else{
            $result= $this::leftJoin('categories', function($join){
                $join->on('articles.category_id','=','categories.id');
            })
            ->leftJoin('users', function($join2){
                $join2->on('articles.user_id','=','users.id');
            })
            ->select('categories.name as cat_name','categories.name_en as cat_name_en', 'users.name as user_name', 'articles.*')
            ->where('articles.created_at','<',$date)
            ->orderBy('articles.created_at', 'desc')
            ->paginate($paginate);
        }
        
        return $result;

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
        ->select('categories.name as cat_name','categories.name_en as cat_name_en','users.name as user_name', 'articles.*')
        ->where('articles.id',$id)
        ->get();
    }

    public function updateArticle($title,$perex,$plot,$tags,$category,$audience,$user_id,$dateArticle,$lang,$id=null){
        if($id==null){
            if($lang=='en'){
                DB::insert("INSERT INTO `articles` (`plot_en`, `title_en`, `category_id`, `perex_en`, `user_id`, `tags`, `audience`,`created_at`,`updated_at`) VALUES (:plot,:title,:category,:perex,:user,:tags,:audience,:created,:updated)",[
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
            }
            else{
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
            }
            return DB::getPdo()->lastInsertId();  
        }
        else{
            if($lang=='en'){
                DB::update("UPDATE `articles` SET `plot_en`=:plot,`title_en`=:title,`category_id`=:category,`perex_en`=:perex,`tags`=:tags,`audience`=:audience,`user_id`=:user,`created_at`=:created WHERE id=:id",[
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
    }

    public function updateArticleCategory($id){
        if(Auth::user()->hasAnyRole(['editor','admin']))
            $this::where('category_id',$id)->update(['category_id' => 1]);
    }

    public function deleteArticle($id){
        if(Auth::user()->hasAnyRole(['editor','admin']))
            $this::where('id',$id)->delete();
    }
}
