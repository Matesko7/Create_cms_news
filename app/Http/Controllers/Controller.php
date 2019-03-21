<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use Illuminate\Http\Request;
use Mail;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index(){
        $config = array();
        $config['center'] = '48.145373, 17.190432';
        $config['zoom'] = '14';

        $marker = array();
        $marker['position'] = '48.145373, 17.190432';
        $marker['infowindow_content'] = "<img style='margin:10px' src=".asset('images/logo-scroll.png')."><p><b>KM CONSULT S.R.O.</b></p><p>Rebarborová 1/B ( areál Harley Davidson )<br>821 07 Bratislava</p><p><span>email: info@kmuctovnictvo.sk <br>tel: +421 915 232 394</span></p>";
  
        \GMaps::add_marker($marker);
        \GMaps::initialize($config);
        $map = \GMaps::create_map();
        
        return view('index', ['map' => $map]);
    }

    public function sluzby(){
        return view('sluzby');
    }

    public function test(){
        return view('test');
    }

}
