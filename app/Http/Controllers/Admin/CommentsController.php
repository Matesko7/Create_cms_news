<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Comment;
use Auth;

class CommentsController extends Controller
{
    public function index(){
        $articles= new Article;
        
        if(Auth::user()->hasRole('admin'))
            $articles=$articles->getCountCommentsPerArticle();

        return view('Admin/Comments/index', ['articles' => $articles]);
    }

    public function commentsPerArticle($article_id){
        $comments = Comment::where('article_id',$article_id)->orderBy('created_at', 'desc')->paginate(25);
        return view('Admin/Comments/edit', ['comments' => $comments]);   
    }

    public function commentApprove($comment_id){
        Comment::where('id',$comment_id)->update(['is_approved' => '1']);
        return redirect()->back();
    }

    public function commentDeny($comment_id){
        Comment::where('id',$comment_id)->update(['is_approved' => '0']);
        return redirect()->back();
    }

}
