<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getRoleByUserID($id){
        return DB::select("SELECT role_id FROM role_user LEFT JOIN roles on role_user.role_id=roles.id where role_user.user_id=:id",[$id]);
    }
}
