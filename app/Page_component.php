<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page_component extends Model
{
    public $timestamps = false;
    public function component()
    {
        return $this->belongsTo('Component');
    }
}
