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
        return view('Admin/menu/index');
    }
}
