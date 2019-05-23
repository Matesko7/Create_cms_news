<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link'
    ];

    public function images() {
        return $this->belongsToMany(Article::class);
    }
}
