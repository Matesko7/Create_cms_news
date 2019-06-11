<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getAllComentswUserByArcticleId($article_id){
        return $this::leftJoin('users', function($join){
            $join->on('comments.user_id','=','users.id');
        })
        ->select('comments.*','users.name as user_name', 'users.id as user_id')
        ->where(['article_id' => $article_id, 'is_approved' => '1','parent_id' => null])
        ->orderBy('comments.created_at', 'desc')
        ->get();
    }

    public function getAllRepliesComentswUserByArcticleId($article_id){
        return $this::leftJoin('users', function($join){
            $join->on('comments.user_id','=','users.id');
        })
        ->select('comments.*','users.name as user_name', 'users.id as user_id')
        ->where(['article_id' => $article_id, 'is_approved' => '1',['parent_id','!=',null]])
        ->orderBy('comments.created_at', 'desc')
        ->get();
    }
}
