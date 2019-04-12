<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Article;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(){
        $categories= new Category;
        $cats=$categories->getAllPaginate();
        foreach ($cats as $key => $cat) {
            if($categories->getCategoryById($cat->parent_id))
                $cats[$key]->parent=$categories->getCategoryById($cat->parent_id)->name;
            else
                $cats[$key]->parent=null;
        }
        return view('Admin/Categories/categories', ['categories' => $cats]);
    }

    public function delete($id){
        $categories= new Category;
        $article= new Article;
        $categories->deleteCategory($id);

        //zmazanie parent_id ak sa parent_category vymazala
        $categories->updateCategoryParent($id);

        //preradenie vsetkych clankov ktore boli v danej kategorii do kategorie nezaradene
        $article->updateArticleCategory($id);
        
        $cats=$categories->getAllPaginate();
        foreach ($cats as $key => $cat) {
            if($categories->getCategoryById($cat->parent_id))
                $cats[$key]->parent=$categories->getCategoryById($cat->parent_id)->name;
            else
                $cats[$key]->parent=null;
        }

        return back()->with(['success' => 'Kategória úspešne zmazaná', 'categories' => $cats]);
    }

    public function edit($id=null){
        $categories= new Category;


        if($id==null){
            return view('Admin//Categories/index',['categories' => $categories->getAll()]);    
        }
        else{
            $cat=$categories->getCategoryById($id);
            if($categories->getCategoryById($cat->parent_id))
                $cat->parent=$categories->getCategoryById($cat->parent_id)->name;
            else
                $cat->parent=null;
            
            return view('Admin//Categories/index', ['category' => $cat,'categories' => $categories->getAll()]);
        }
    }

    
    public function save(Request $request,$id=null){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $categories= new Category;
        if($request->cat_parent==1) $request->cat_parent=NULL;
        if($id==null){
            $id_new_cat=$categories->updateCategory($request->name,$request->cat_parent);
            return redirect(asset("admin/categories"))->with('success','Kategória pridaná');
        }
        else{
            $categories->updateCategory($request->name,$request->cat_parent,$id);
            return back()->with('success','Kategória aktualizovaná');
        }
    }



    public function new($category_name,$parent_category){
    if($parent_category==1) $parent_category=NULL;
    if(Category::where('name',$category_name)->first())
        return 'Kategória s týmto nazvom už existuje';
    $category= new Category;
    $category->name=$category_name;
    $category->parent_id=$parent_category;
    $category->save();
    return DB::getPdo()->lastInsertId();
    }
}
