<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'array',
    ];

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
    if (is_array($roles)) {
        return $this->hasAnyRole($roles) || 
                abort(401, 'This action is unauthorized.');
    }
    return $this->hasRole($roles) || 
            abort(401, 'This action is unauthorized.');
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
    return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
    return null !== $this->roles()->where('name', $role)->first();
    }

    public function userRole($id){
        return DB::select("SELECT roles.name FROM role_user LEFT JOIN roles ON role_user.role_id=roles.id WHERE role_user.user_id=$id");
    }

    public function getAll($id=null){
        if($id==null)
            return DB::select("SELECT roles.name role,users.* FROM role_user LEFT JOIN roles ON role_user.role_id=roles.id LEFT JOIN users ON role_user.user_id=users.id");
        else
            return DB::select("SELECT roles.name role,users.* FROM role_user LEFT JOIN roles ON role_user.role_id=roles.id LEFT JOIN users ON role_user.user_id=users.id WHERE role_user.id=$id");
    }

    public function updateNameEmail($name,$email){
    $id=Auth::user()->id;
    DB::update("UPDATE users SET name = :name,email= :email WHERE id=$id",['name'=>$name,'email' => $email]);
    }

}
