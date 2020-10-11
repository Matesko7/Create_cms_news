<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Harimayco\Menu\Facades\Menu;
use Harimayco\Menu\Models\MenuItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function showMenus(Request $request){
        $menuId = $request->query('menu');
        if($menuId != ''){
            return view('Admin/Menu/index');
        }
        $menus= DB::select("select * from admin_menus");
        return view('Admin/Menu/index2',['menus' => $menus]);
    }

    public function selectedMenuChange($lang,$menuId){
        if($lang != 'en' and $lang != 'sk'){
            return redirect(asset('admin/menu'))->with('warning','Neplatný jazyk');
        }

        if($lang == 'sk'){
            DB::update("UPDATE admin_menus SET selected_sk=0");
            DB::update("UPDATE admin_menus SET selected_sk=1 where id=$menuId");
        }
        else{
            DB::update("UPDATE admin_menus SET selected_en=0");
            DB::update("UPDATE admin_menus SET selected_en=1 where id=$menuId");
        }

        return redirect(asset('admin/menu'))->with('success','Menu zmenené');
    }
    
    public function deleteMenu($menuId){
        DB::delete("DELETE FROM admin_menu_items WHERE menu=:id",["id" => $menuId]);
        DB::delete("DELETE FROM admin_menus WHERE id=:id",["id" => $menuId]);

        return redirect(asset('admin/menu'))->with('success','Menu vymazané');
    }
    
}
