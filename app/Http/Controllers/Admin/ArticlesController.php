<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Category;
use App\User;
use App\Image;
use Illuminate\Support\Facades\DB;
use Auth;
use URL;

class ArticlesController extends Controller
{
    public function index(){
        $articles= new Article;
        
        if(Auth::user()->hasRole('admin'))
            $articles=$articles->getAllwAuthorandGroup();
        if(Auth::user()->hasRole('editor'))
            $articles=$articles->getPerEditorwAuthorandGroup();            

        return view('Admin/Articles/articles', ['articles' => $articles]);
    }

    public function edit($lang='sk',$id=null){
        // length of hash to generate, up to the output length of the hash function used
        $length = 6;
        // The following should retrieve the date down to your desired resolution.
        // If you want a daily code, retrieve only the date-specific parts
        // For hourly resolution, retrieve the date and hour, but no minute parts
        $today = date("m.d.y H:m:s:u"); // e.g. "03.10.01"
        $hash = substr(hash('md5', $today), 0, $length); // Hash it
        
        $article= new Article;
        $category= new Category;
        $categories= $category->getAll();
        $article_photo=false;
        if($id!=null){
            $article_category=$article->getCategoryByArticleId($id);
            if(!$article_category)
                $article_category=1; //nezaradene
            
            $articles=$article->getArticle($id);
            $tags= explode("|",$articles[0]->tags);

            $photos= glob("articles/$id/cover/*"); // get all file names
            foreach($photos as $value){ // iterate files
                if(is_file($value))
                    $article_photo=$value;
            }  

            $galery= DB::select("SELECT * from article_image RIGHT JOIN images ON article_image.image_id=images.id WHERE article_image.article_id=? ORDER BY order_image",[$id]);

            $attachments= DB::select("SELECT * from article_attachment WHERE article_id=? ORDER BY id desc",[$id]);
            
            $related_articles= DB::select("SELECT A.*,B.title from aritcle_related A  LEFT JOIN articles B on A.related_article_id=B.id WHERE A.article_id=? ORDER BY id desc",[$id]);


            $all_articles= DB::select("SELECT id,title from articles");
            

            return view('Admin/Articles/article_detail', ['article' => $article->getArticle($id),'categories' => $categories,'article_category' => $article_category,'tags'=> $tags,'article_photo' => $article_photo, 'galery' => $galery, 'lang' => $lang, 'pic_hash' => $hash, 'attachments' => $attachments, 'related_articles' => $related_articles, 'articles' => $all_articles]);
        }
        else{
            $photos= glob("articles/tmp/cover/*"); // get all file names
            foreach($photos as $value){ // iterate files
                if(is_file($value))
                    unlink($value);
            }
            return view('Admin/Articles/article_new',['categories' => $categories,'article_photo' => $article_photo, 'lang' => $lang, 'pic_hash' => $hash]);
        }
    }

    public function save(Request $request,$id=null){
        
        $now= date("Y-m-d H:i:s");
        $photos= glob("articles/tmp/*"); // get all file names
        foreach($photos as $value){ // iterate files
            if(is_file($value))
                if(date("Y-m-d H:i:s",filectime($value)) < date('Y-m-d H:i:s',strtotime($now . "-1 days")))
                    unlink($value);
        }

        $this->validate($request, [
            'title' => 'required',
            'perex' => 'required',
            'editor' => 'required',
            "attachment.*"  => 'max: 51200' ,
        ]);
        

        $tmp_tags="";
        if(!empty($request->tags)){
            foreach($request->tags as $key=>$tag){
                if($key==0)
                    $tmp_tags=$tag;
                else 
                    $tmp_tags=$tmp_tags."|".$tag;
            };
        }

        if(empty($request->category))
            $request->category=array(1);
        $article= new Article;
        if($request->dateArticle=="okamžite")
            $request->dateArticle=date("Y-m-d H:i:s");
        else{
            $tmp=explode("/",$request->dateArticle);
            $request->dateArticle=$tmp[2].'-'.$tmp[0].'-'.$tmp[1].' 00:00:00' ;
        } 

 
        if($id==null){
            $plot=str_replace(array("\n","\r","&#9;"),array("","",""),$request->editor);
            $id_new_article=$article->updateArticle($request->title,$request->perex,$plot,$tmp_tags,$request->category[count($request->category)-1],$request->audience,Auth::user()->id,$request->dateArticle,$request->lang);

            $plot=str_replace(array("\n","\r","&#9;","/articles/tmp/"),array("","","","/articles/".$id_new_article."/"),$request->editor);

            $article->updateArticle($request->title,$request->perex,$plot,$tmp_tags,$request->category[count($request->category)-1],$request->audience,Auth::user()->id,$request->dateArticle,$request->lang,$id_new_article);

            //ulozenie nahrateho suboru
            $file = $request->file('file');
            if(isset($file)){
                $photos= glob("articles/$id_new_article/cover/*"); // get all file names
                foreach($photos as $value){ // iterate files
                    if(is_file($value))
                        unlink($value);
                }
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $size= $_FILES['file']['size'];
                $file->move(base_path('public/articles/'.$id_new_article.'/cover'),'cover_photo.'.$path_parts['extension']);
            }

            if (!file_exists('articles/'.$id_new_article)) {
                mkdir('articles/'.$id_new_article, 0777, true);
            }

            //presunutie ponahravanych fotiek vramci clanku
            $photos= glob("articles/tmp/*"); // get all file names
            foreach($photos as $value){ // iterate files
                if(is_file($value))
                    if(substr(basename($value),0,6) == $request->pic_hash)
                        rename ($value , 'articles/'. $id_new_article.'/'.basename($value));
            }

            return redirect(asset("admin/article/sk/$id_new_article"))->with('success','Článok pridaný');
        }
        else{
            //ulozenie nahrateho suboru
            $file = $request->file('file');
            if(isset($file)){
                $photos= glob("articles/$id/cover/*"); // get all file names
                foreach($photos as $value){ // iterate files
                    if(is_file($value))
                        unlink($value);
                }
                $path_parts = pathinfo($_FILES["file"]["name"]);
                $size= $_FILES['file']['size'];
                $file->move(base_path('public/articles/'.$id.'/cover'),'cover_photo.'.$path_parts['extension']);
            }


            //ulozenie priloh
            if( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty($_FILES[ 'attachment']) ){
                if (!file_exists('articles/'.$id.'/attachments')) {
                    mkdir('articles/'.$id.'/attachments', 0777, true);
                }
                foreach( $_FILES['attachment']['name'] as $index => $name ){
                    if($name){
                        move_uploaded_file($_FILES['attachment']['tmp_name'][$index],'articles/'.$id.'/attachments/'.$name );
                        $attach_name=$request->name_attachment[$index];
                        DB::insert("INSERT INTO article_attachment (article_id, link,attach_name) VALUES ($id,'articles/$id/attachments/$name','$attach_name')");
                        /*}
                        else
                            DB::update("UPDATE article_attachment  set link= 'articles/$id/attachments/$name' where article_id=$id and attach_order=($index)");
                        */
                    }
                }
            }

            
			$plot=str_replace(array("\n","\r","&#9;","/articles/tmp/"),array("","","","/articles/".$id."/"),$request->editor);
            
            //presunutie ponahravanych fotiek vramci clanku
            $photos= glob("articles/tmp/*"); // get all file names
            foreach($photos as $value){ // iterate files
                if(is_file($value))
                    if(substr(basename($value),0,6) == $request->pic_hash)
                        rename ($value , 'articles/'. $id.'/'.basename($value));
            }

            $article->updateArticle($request->title,$request->perex,$plot,$tmp_tags,$request->category[count($request->category)-1],$request->audience,$request->user_id,$request->dateArticle,$request->lang,$id);
            return back()->with('success','Článok aktualizovaný');
        }
    }

    public function attachemnt_delete($id){
        $attachment= DB::select("SELECT * from article_attachment where id=?",[$id]);
        if(file_exists($attachment[0]->link))
            unlink($attachment[0]->link);
        DB::delete("DELETE from article_attachment where id=?", [$id]);
        return back()->with('success', 'Príloha úspešne vymazaná');
    }


    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        $photos= glob("articles/$id/*"); // get all file names
        foreach($photos as $value){ // iterate files
            if(is_file($value))
                unlink($value);
        }

        $attachments= glob("articles/$id/attachments/*"); // get all file names
        foreach($attachments as $value){ // iterate files
            if(is_file($value))
                unlink($value);
        }

        $gallery= glob("articles/$id/galery/*"); // get all file names
        foreach($gallery as $value){ // iterate files
            if(is_file($value))
                unlink($value);
        }

        $cover= glob("articles/$id/cover/*"); // get all file names
        foreach($cover as $value){ // iterate files
            if(is_file($value))
                unlink($value);
        }

        if (is_dir("articles/$id/cover")) {
            rmdir("articles/$id/cover");
        }
        if (is_dir("articles/$id/galery")) {
            rmdir("articles/$id/galery");
        }
        if (is_dir("articles/$id/attachments")) {
            rmdir("articles/$id/attachments");
        }
        if (is_dir("articles/$id")) {
            rmdir("articles/$id");
        }
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }

    public function newImageToGalery(Request $request){
            if (!file_exists('articles/'.$request->article_id.'/galery')) {
                mkdir('articles/'.$request->article_id.'/galery', 0777, true);
            }

            $tmp= explode("/",$request->src); 
            $image_name= end($tmp);
            
            $from=str_replace(URL::to('/').'/','',$request->src);

            $to= 'articles/'.$request->article_id.'/galery/'.$image_name;

            $image= Image::create([
                'link' => $to
            ]);

            $order= DB::select("select max(order_image) as poradie from article_image where article_id=$request->article_id")[0]->poradie;

            if(!$order) 
                $order=1;
            else
                $order++;
                
            $image->images()->attach($request->article_id,['order_image' => $order]);

            copy($from,$to);

            return $image->id;
    }

    public function newRelatedArcticle(Request $request){
        DB::insert("INSERT INTO aritcle_related (related_article_id,article_id) VALUES ($request->related_article, $request->article_id)");
        $id= DB::getPdo()->lastInsertId();  
        return DB::select("SELECT A.id id ,B.title title from aritcle_related A LEFT JOIN articles B on A.related_article_id=B.id where A.id=$id");
    }

    public function deleteRelatedArcticle($id){
        DB::delete("DELETE from aritcle_related where id=$id");
        
    }


    public function editImage(Request $request){
        Auth::user()->authorizeRoles('admin','editor');
        
        if($request->action=="1"){//posun fotky do LAVA
            
            $photo= DB::select ('SELECT * FROM article_image WHERE article_id=? AND image_id=?',[$request->article_id,$request->image_id]);

            //zistim ci som na zaciatku teda ci potrebujem prehodit prvu foto na posledne miesto
            $next_photo= DB::select ('SELECT * FROM article_image WHERE article_id=? AND order_image=?',[$request->article_id,$photo[0]->order_image-1]);
            

            if(!empty($next_photo)){    
                DB::update('UPDATE article_image SET order_image=order_image-1  WHERE article_id=? AND id=?',[$request->article_id,$photo[0]->id]);
                
                DB::update('UPDATE article_image SET order_image=order_image+1 WHERE article_id=? AND id=?',[$request->article_id,$next_photo[0]->id]);
            }   
            else {
                $max_order=DB::select('SELECT MAX(order_image) as M FROM article_image WHERE article_id=?',[$request->article_id]);
    
                DB::update('UPDATE article_image SET order_image='.$max_order[0]->M.' WHERE article_id=? AND id=?',[$request->article_id,$photo[0]->id]);
    
                DB::update('UPDATE article_image SET order_image=order_image-1  WHERE article_id=? AND id!=?',[$request->article_id,$photo[0]->id]);
            }
            
            $galery= DB::select("SELECT * from article_image RIGHT JOIN images ON article_image.image_id=images.id WHERE article_image.article_id=? ORDER BY order_image",[$request->article_id]);
            return $galery; 
        }
        if($request->action=="2"){ //zmazanie fotky

            $img=Image::where('id', $request->image_id)->get()[0];
            
            if (file_exists($img->link)) {
                unlink($img->link);
            }

            Image::where('id', $request->image_id)->delete();

            $images=DB::select('SELECT * from article_image WHERE article_id=? ORDER BY order_image',[$request->article_id]);
            
            foreach ($images as $key => $value) {
                DB::update('UPDATE article_image SET order_image='.($key+1).' WHERE article_id=? and image_id=?',[$request->article_id,$value->image_id]);
            }
            
            $galery= DB::select("SELECT * from article_image RIGHT JOIN images ON article_image.image_id=images.id WHERE article_image.article_id=? ORDER BY order_image",[$request->article_id]);
            return $galery; 
        }

        if($request->action=="3"){ //posun fotky do PRAVA
            
            $photo= DB::select ('SELECT * FROM article_image WHERE article_id=? AND image_id=?',[$request->article_id,$request->image_id]);

            //zistim ci som na konci teda ci potrebujem prehodit poslednu foto na prve miesto
            $next_photo= DB::select ('SELECT * FROM article_image WHERE article_id=? AND order_image=?',[$request->article_id,$photo[0]->order_image+1]);
            

            if(!empty($next_photo)){    
                DB::update('UPDATE article_image SET order_image=order_image+1  WHERE article_id=? AND id=?',[$request->article_id,$photo[0]->id]);
                
                DB::update('UPDATE article_image SET order_image=order_image-1 WHERE article_id=? AND id=?',[$request->article_id,$next_photo[0]->id]);
            }   
            else {
                DB::update('UPDATE article_image SET order_image=1 WHERE article_id=? AND id=?',[$request->article_id,$photo[0]->id]);
    
                DB::update('UPDATE article_image SET order_image=order_image+1  WHERE article_id=? AND id!=?',[$request->article_id,$photo[0]->id]);
            }
            
            $galery= DB::select("SELECT * from article_image RIGHT JOIN images ON article_image.image_id=images.id WHERE article_image.article_id=? ORDER BY order_image",[$request->article_id]);
            return $galery; 
        }
    }

    public function selectedArticles(){
        $articles = Article::orderBY('created_at')->get();
        $articles_selected= Article::where('selected_article','!=',null)->get();
        $tmp_array=array("1" => null,"2" => null,"3" => null,"4" => null,"5" => null,"6" => null);

        foreach ($articles_selected as $key => $value) {
            $tmp_array[$value->selected_article]= $value; 
        }

        return view('Admin.Articles.selected',['articles' => $articles, 'articles_selected' => $tmp_array]);
    }

    public function selectedArticlesSave(Request $request){
        
        if($request->article_selected_6 == 0){
            Article::where('selected_article',6)->update(['selected_article' => null]);
        }
        else{
            Article::where('id',$request->article_selected_6)->update(['selected_article' => 6]);
        }

        
        if($request->article_selected_5 == 0){
            Article::where('selected_article',5)->update(['selected_article' => null]);
        }
        else{
            Article::where('id',$request->article_selected_5)->update(['selected_article' => 5]);
        }
        
        if($request->article_selected_4 == 0){
            Article::where('selected_article',4)->update(['selected_article' => null]);
        }
        else{
            Article::where('id',$request->article_selected_4)->update(['selected_article' => 4]);
        }

        if($request->article_selected_3 == 0){
            Article::where('selected_article',3)->update(['selected_article' => null]);
        }
        else{
            Article::where('id',$request->article_selected_3)->update(['selected_article' => 3]);
        }

        if($request->article_selected_2 == 0){
            Article::where('selected_article',2)->update(['selected_article' => null]);
        }
        else{
            Article::where('id',$request->article_selected_2)->update(['selected_article' => 2]);
        }


        if($request->article_selected_1 == 0){
            Article::where('selected_article',1)->update(['selected_article' => null]);
        }
        else{
            Article::where('id',$request->article_selected_1)->update(['selected_article' => 1]);
        }
        
        return redirect()->back()->with('success','Vybrané články aktualizované');  
    }
}
