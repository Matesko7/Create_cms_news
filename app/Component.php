<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function page_components(){
        return $this->hasMany('Page_component');
    }
}
