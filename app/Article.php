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

    public function getAudienceRoleByArticleId($id){
        return DB::select("SELECT audience_role FROM articles LEFT JOIN roles ON articles.audience_role=roles.id WHERE articles.id=:id",['id' => $id]);
    }

    public function getAllwAuthorandGroup($paginate=15,$date='2030-01-01 00:00:00',$category=false,$tag=false){

        if($category && $tag){
            $result= $this::leftJoin('categories', function($join){
                $join->on('articles.category_id','=','categories.id');
            })
            ->leftJoin('users', function($join2){
                $join2->on('articles.user_id','=','users.id');
            })
            ->leftJoin('comments', function($join3){
                $join3->on('articles.id','=','comments.id');
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

    public function getAllwAuthorandGroupPerUser($userId,$paginate=15){

        $result= $this::leftJoin('categories', function($join){
            $join->on('articles.category_id','=','categories.id');
        })
        ->leftJoin('users', function($join2){
            $join2->on('articles.user_id','=','users.id');
        })
        ->leftJoin('comments', function($join3){
            $join3->on('articles.id','=','comments.id');
        })
        ->select('categories.name as cat_name','categories.name_en as cat_name_en', 'users.name as user_name', 'articles.*')
        ->where('articles.user_id',$userId)
        ->orderBy('articles.created_at', 'desc')
        ->paginate($paginate);
        return $result;
    }

    public function getCountCommentsPerArticle(){
        /*return $this::leftJoin('comments', function($join){
            $join->on('comments.article_id','=','articles.id');
        })
        ->select( COUNT('comments.id'),'articles.tsitle')
        ->orderBy('articles.created_at', 'desc')
        ->get();*/
        
        return DB::select("SELECT articles.title,articles.id,COUNT(comments.id) as comment_count FROM articles LEFT JOIN comments ON comments.article_id = articles.id GROUP BY articles.title,articles.id");
        
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

    public function updateArticle($meta_tag_desc,$meta_tag_keyw,$title,$perex,$plot,$tags,$category,$audience,$audince_role_id,$user_id,$dateArticle,$lang,$allowComment,$id=null){
        if($id==null){
            if($lang=='en'){
                DB::insert("INSERT INTO `articles` (`plot_en`, `title_en`, `category_id`, `perex_en`, `user_id`, `tags`, `audience`, `audience_role_id`, `meta_tag_Description`,`meta_tag_Keyword`,`allowComment`,`created_at`,`updated_at`) VALUES (:plot,:title,:category,:perex,:user,:tags,:audience,:audienceRoleId,:metaTagDesc,:metaTagKeyw,:allowComment,:created,:updated)",[
                    'plot' => $plot,
                    'title' => $title,
                    'category' => $category,
                    'perex' => $perex,
                    'tags' => $tags,
                    'audience' => $audience,
                    'audienceRoleId' => $audince_role_id,
                    'metaTagDesc' => $meta_tag_desc,
                    'metaTagKeyw' => $meta_tag_keyw,
                    'allowComment' => $allowComment,
                    'user' => $user_id,
                    'created' => $dateArticle,
                    'updated' => date("Y-m-d H:i:s")
                    ]);
            }
            else{
                DB::insert("INSERT INTO `articles` (`plot`, `title`, `category_id`, `perex`, `user_id`, `tags`, `audience`, `audience_role_id`, `meta_tag_Description`,`meta_tag_Keyword`,`allowComment`,`created_at`,`updated_at`) VALUES (:plot,:title,:category,:perex,:user,:tags,:audience,:audienceRoleId,:metaTagDesc,:metaTagKeyw,:allowComment,:created,:updated)",[
                    'plot' => $plot,
                    'title' => $title,
                    'category' => $category,
                    'perex' => $perex,
                    'user' => $user_id,
                    'tags' => $tags,
                    'audience' => $audience,
                    'audienceRoleId' => $audince_role_id,
                    'metaTagDesc' => $meta_tag_desc,
                    'metaTagKeyw' => $meta_tag_keyw,
                    'allowComment' => $allowComment,
                    'created' => $dateArticle,
                    'updated' => date("Y-m-d H:i:s")
                    ]);
            }
            return DB::getPdo()->lastInsertId();  
        }
        else{
            if($lang=='en'){
                DB::update("UPDATE `articles` SET `plot_en`=:plot,`title_en`=:title,`category_id`=:category,`perex_en`=:perex,`tags`=:tags,`audience`=:audience,`audience_role_id`=:audienceRoleId,`meta_tag_Description`=:metaTagDesc,`meta_tag_Keyword`=:metaTagKeyw,`allowComment`=:allowComment,`user_id`=:user,`created_at`=:created WHERE id=:id",[
                    'plot' => $plot,
                    'title' => $title,
                    'category' => $category,
                    'perex' => $perex,
                    'tags' => $tags,
                    'audience' => $audience,
                    'audienceRoleId' => $audince_role_id,
                    'metaTagDesc' => $meta_tag_desc,
                    'metaTagKeyw' => $meta_tag_keyw,
                    'allowComment' => $allowComment,
                    'user' => $user_id,
                    'id' => $id,
                    'created' => $dateArticle
                ]);
            }
            else{
                DB::update("UPDATE `articles` SET `plot`=:plot,`title`=:title,`category_id`=:category,`perex`=:perex,`tags`=:tags,`audience`=:audience,`audience_role_id`=:audienceRoleId,`meta_tag_Description`=:metaTagDesc,`meta_tag_Keyword`=:metaTagKeyw,`allowComment`=:allowComment,`user_id`=:user,`created_at`=:created WHERE id=:id",[
                    'plot' => $plot,
                    'title' => $title,
                    'category' => $category,
                    'perex' => $perex,
                    'tags' => $tags,
                    'audience' => $audience,
                    'audienceRoleId' => $audince_role_id,
                    'metaTagDesc' => $meta_tag_desc,
                    'metaTagKeyw' => $meta_tag_keyw,
                    'allowComment' => $allowComment,
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
