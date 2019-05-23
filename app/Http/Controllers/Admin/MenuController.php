<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Harimayco\Menu\Facades\Menu;
use Harimayco\Menu\Models\MenuItems;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(){
        $menus= DB::select("select * from admin_menus");
        return view('Admin/Menu/index',['menus' => $menus]);
    }

    public function selectedMenuChange($sk,$en){
        DB::update("UPDATE admin_menus SET selected_sk=0,selected_en=0 ");
        DB::update("UPDATE admin_menus SET selected_sk=1 where id=$sk");
        DB::update("UPDATE admin_menus SET selected_en=1 where id=$en");
        return redirect(asset('admin/menu'))->with('success','Menu zmenené');
    }
    
}
