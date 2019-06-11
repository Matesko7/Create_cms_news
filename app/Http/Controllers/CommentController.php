<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Comment;
use Redirect;

class CommentController extends Controller
{
    public function save($article_id, Request $request){
        
        $this->validate($request, [
            'comment' => 'required|max:1000',
        ]);

        $comment= new Comment;
        $comment->article_id=$article_id;
        $comment->comment=$request->comment;
        $comment->user_id= Auth::user()->id;
        $comment->save();
        return Redirect::back()->with('success','Koment úspešne pridaný');
    }

    public function reply($article_id,$comment_id, Request $request){
        
        $this->validate($request, [
            'comment_reply' => 'required|max:1000',
        ]);

        $comment= new Comment;
        $comment->article_id=$article_id;
        $comment->comment=$request->comment_reply;
        $comment->user_id= Auth::user()->id;
        $comment->parent_id= $comment_id;
        $comment->save();
        return Redirect::back()->with('success','Odpoved úspešne pridaná');
    }
}
