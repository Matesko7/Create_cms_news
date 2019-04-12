<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public $timestamps = false;

    public function getAll(){
        return $this::orderBy('name')->get();
    }

    public function getAllPaginate(){
        return $this::where('id','!=',1)->orderBy('name')->paginate(15);
    }

    public function getCategoryById($id){
        if($id==null) return;
        return $this::where('id',$id)->get()[0];
    }

    public function deleteCategory($id){
        if($id==1) return //kategoria nezaradene sa neda zmazat
        Auth::user()->authorizeRoles('admin');
        $this::where('id',$id)->delete();
    }

    public function updateCategoryParent($id){
        if(Auth::user()->hasAnyRole(['editor','admin']))
            $this::where('parent_id',$id)->update(['parent_id' => null]);
    }

    public function updateCategory($name,$cat_parent,$id=null){
        if($id==null){
            DB::insert("INSERT INTO `categories` (`name`,`parent_id`) values (:name, :parent_id)",['name' => $name, 'parent_id' => $cat_parent]);
            return DB::getPdo()->lastInsertId();
        }
        else
            DB::update("UPDATE `categories` SET `name`=:name, `parent_id`=:parent_id WHERE `id`=:id",['name' => $name, 'parent_id' => $cat_parent,'id' => $id]);
    }
}
