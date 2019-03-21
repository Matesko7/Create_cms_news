<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Article;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['visitor', 'editor','admin']);

        if(Auth::user()->hasRole('visitor'))
                return redirect('/');

        if(Auth::user()->hasAnyRole(['editor','admin'])){
            return redirect('/profile');
        }
    }

}
