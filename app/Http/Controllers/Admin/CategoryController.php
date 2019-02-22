<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function new($category_name){
    $category= new Category;
    $category->name=$category_name;
    $category->save();
    return DB::getPdo()->lastInsertId();
    }
}
