<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarouselController extends Controller
{
    public function index(){
            $photo_1=false;
            $photo_2=false;
            $photo_3=false;
            $photo_4=false;
            $photo_5=false;
            $photo_6=false;
            $photo_7=false;
            $photo_8=false;
            if(is_file('carousel/1.jpg'))
                $photo_1= true;
            if(is_file('carousel/2.jpg'))
                $photo_2= true;
            if(is_file('carousel/3.jpg'))
                $photo_3= true;
            if(is_file('carousel/4.jpg'))
                $photo_4= true;
            if(is_file('carousel/5.jpg'))
                $photo_5= true;
            if(is_file('carousel/6.jpg'))
                $photo_6= true;
            if(is_file('carousel/7.jpg'))
                $photo_7= true;
            if(is_file('carousel/8.jpg'))
                $photo_8= true;
    
            return view('Admin/Carousel/index')->with(['photo_1' => $photo_1,'photo_2' => $photo_2,'photo_3' => $photo_3,'photo_4' => $photo_4,'photo_5' => $photo_5,'photo_6' => $photo_6,'photo_7' => $photo_7,'photo_8' => $photo_8]);
    }
}
