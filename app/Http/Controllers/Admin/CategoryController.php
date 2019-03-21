<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
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
