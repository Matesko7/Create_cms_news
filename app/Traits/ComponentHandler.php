<?php

namespace App\Traits;
use App\Article;
use App\Category;
use App\Comment;
use App\Role;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;


trait ComponentHandler
{

    public function Articles($category=false,$tag=false){        
        $article= new Article;
        $category_param=false;
        $tag_param=false;

        if($category && $category!==0){
            $tmp=(integer)$this->makeSafe($category);
            if(is_integer($tmp)){
                $category_param=$tmp;
            }
        }
        if($tag && $tag !==0 ){
            $tag_param=$this->makeSafe($tag);
        }

        if(DB::select("SELECT value FROM general_options where type_id=7")){
            $articlesPerPage= DB::select("SELECT value FROM general_options where type_id=7")[0]->value;
        }
        else{
            $articlesPerPage=10;
        }

        if($category_param && $tag_param){
            $articles=$article->getAllwAuthorandGroup($articlesPerPage,date("Y-m-d H:i:s"),$category_param,$tag_param);
        }
        else if($category_param)
            $articles=$article->getAllwAuthorandGroup($articlesPerPage,date("Y-m-d H:i:s"),$category_param);
        else if($tag_param)
            $articles=$article->getAllwAuthorandGroup($articlesPerPage,date("Y-m-d H:i:s"),false,$tag_param);
        else{
            $articles=$article->getAllwAuthorandGroup($articlesPerPage,date("Y-m-d H:i:s"));
        }

        if(!count($articles)){
            return array('error' => 'Danému filtru nevyhovujú žiadne články');
        }
        
        $categories=Category::where('id','!=',1)->get();
        $tags= $article->getAllTags();

        foreach ($articles as $key => $value) {
            $articles[$key]->photo=false;
            $photos= glob("articles/$value->id/cover/*"); // get all file names
            foreach($photos as $photo){ // iterate files
                if(is_file($photo))
                    $articles[$key]->photo=$photo;
            }
        }

        return array('articles' => $articles,'categories' => $categories, 'tags' => $tags, 'category' => $category_param, 'tag' =>$tag_param);
    }

    public function ArticlesPerUser($id){        
        $category_param=false;
        $tag_param=false;
        if( !$user= User::where('id',$id)->first()){
            return array('warning' => 'Hladaný uživateľ neexistuje');
        }
        
        $article= new Article;
        $articles=$article->getAllwAuthorandGroupPerUser($id);
        $categories=Category::where('id','!=',1)->get();
        $tags= $article->getAllTags();

        if($articles){
            foreach ($articles as $key => $value) {
                $articles[$key]->photo=false;
                $photos= glob("articles/$value->id/cover/*"); // get all file names
                foreach($photos as $photo){ // iterate files
                    if(is_file($photo))
                        $articles[$key]->photo=$photo;
                }
            }
        }

        $user->photo=false;
        $photo= glob("users/$id/*"); // get all file names
        foreach($photo as $value){ // iterate files
            if(is_file($value))
                $user->photo=$value;
        }  

        return array('articles' => $articles,'categories' => $categories, 'tags' => $tags, 'category' => $category_param, 'tag' =>$tag_param, 'user' => $user);
    }

    public function Article($id){
        $article_tmp= new Article;
        $comments_tmp= new Comment;
        $article= $article_tmp->getArticlewAuthorandGroup($id);
        if( empty($article[0]))
            return array('warning' => 'Tento článok neexistuje');
        if($article[0]->audience==2){
            if(!isset(Auth::user()->email) || !Auth::user()->email_verified_at)
                return array('warning' => 'Tento článok je len pre prihlasených použivateľov. Ak si ho chcete prečítať prosim prihláste sa');
        }

        if($article[0]->audience_role_id){
            if(!isset(Auth::user()->email) || !Auth::user()->email_verified_at)
                return array('warning' => 'Tento článok je len pre prihlasených použivateľov. Ak si ho chcete prečítať prosim prihláste sa');
            $role= new Role;
            $role_id=$role->getRoleByUserID(Auth::user()->id)[0]->role_id;
            $article_audience_role= Role::where('id',$article[0]->audience_role_id)->get()[0];
            if( $article[0]->audience_role_id != $role_id && $role_id != 2)
                return array('warning' => 'Tento článok je len pre uživateľov s rolou '.$article_audience_role['name']);
        }

        $article[0]->photo=false;
        $tags=explode("|",$article[0]->tags);
        $photos= glob("articles/$id/cover/*"); // get all file names
        foreach($photos as $photo){ // iterate files
            if(is_file($photo))
                $article[0]->photo=$photo;
        }

        $comments= $comments_tmp->getAllComentswUserByArcticleId($id);

        $tmp_comments_reply=$comments_tmp->getAllRepliesComentswUserByArcticleId($id);

        foreach ($comments as $key1 => $comment) {
            $tmp= array();
            foreach ($tmp_comments_reply as $key2 => $comment_reply) {
                if($comment->id == $comment_reply->parent_id){
                    $tmp2= array('userId' => $comment_reply->user_id,'userName' => $comment_reply->user_name,'created_at' => $comment_reply->created_at,'plot' => $comment_reply->comment);
                    array_push($tmp,$tmp2);
                }
            }
            $comments[$key1]->child = $tmp;
        }
        $categories_all=Category::where('id','!=',1)->get();
        $tags_all= $article_tmp->getAllTags();
       
        $attachments= DB::select("SELECT * FROM article_attachment where article_id=$id");
        $extra_tags= DB::select("SELECT * FROM article_tags where article_id=$id");
        $related_articles= DB::select("SELECT * FROM aritcle_related A LEFT JOIN articles B on A.related_article_id=B.id where A.article_id=$id");
        $gallery= DB::select("SELECT * FROM article_image A LEFT JOIN  images B on A.image_id=B.id where A.article_id=$id");

        
        //KONTROLA NA PRAVA NA EDITOVANIE CLANKU
        $editor= false;
        if(Auth::check() && Auth::user()->hasRole('editor')){
            $result = Article::where(['id' => $id, 'user_id' => Auth::user()->id])->get();
            if (!$result->isEmpty())
                $editor= true;
        }

        if(Auth::check() && Auth::user()->hasRole('admin'))
                $editor= true;

        return array('article' => $article,'tags' =>$tags,'tags_all' => $tags_all, 'categories_all' => $categories_all,'comments' => $comments,'attachments' => $attachments,'gallery' => $gallery,'related_articles' => $related_articles, 'editor' => $editor , 'extra_tags' => $extra_tags);
    }

    private function makeSafe($file) {
        $file = rtrim($file, '.');
        $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
        return trim(preg_replace($regex, '', $file));
    }

    public function map($latitude,$longitude,$text,$link){
        $config = array();
        $config['center'] = $latitude.','.$longitude;
        $config['zoom'] = '14';

        $marker = array();
        $marker['position'] = $latitude.','.$longitude;
        $text = str_replace("\n", "<br />", $text);
        $text = trim(preg_replace('/\s+/', ' ', $text));
        $marker['infowindow_content'] = "<img style='margin:10px;height:75px;' src='".asset($link)."'><p>$text</p>";

        \GMaps::add_marker($marker);
        \GMaps::initialize($config);
        return $map = \GMaps::create_map();
    }

    public function News(){
        return DB::select("SELECT articles.*, users.name as author FROM articles LEFT JOIN users on articles.user_id=users.id order by created_at limit 6");
    }

    public function Top_articles(){
       return DB::select("SELECT articles.*, users.name as author FROM articles LEFT JOIN users on articles.user_id=users.id WHERE selected_article !=0 order by selected_article limit 6");
    }

    function recursiveRemove($dir) {
        $structure = glob(rtrim($dir, "/").'/*');
        if (is_array($structure)) {
            foreach($structure as $file) {
                if (is_dir($file)) recursiveRemove($file);
                elseif (is_file($file)) unlink($file);
            }
        }
        rmdir($dir);
    }
        
}