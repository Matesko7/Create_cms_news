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
            return DB::select("SELECT roles.name role,users.* FROM users INNER JOIN role_user ON users.id=role_user.user_id INNER JOIN roles ON role_user.role_id=roles.id");
        else
            return DB::select("SELECT roles.id roleId,roles.name role,users.* FROM role_user LEFT JOIN roles ON role_user.role_id=roles.id LEFT JOIN users ON role_user.user_id=users.id WHERE role_user.user_id=?",[$id]);
    }

    public function updateNameEmail($name,$email,$id=null,$role=null){
        if($id==null){
            //uzivatel meni svoje udaje
            $id=Auth::user()->id;        
        }
        else{
            //admin meni udaje pouzivatelom
            DB::update("UPDATE role_user SET role_id= :role WHERE user_id=:id",['role'=>$role,'id' => $id]);
        }
        DB::update("UPDATE users SET name = :name,email= :email WHERE id=:id",['name'=>$name,'email' => $email,'id' => $id]);

    }

    public function deleteUser($id){
        Auth::user()->authorizeRoles('admin');
        if (file_exists("users/$id.jpg"))
        unlink("users/$id.jpg");
        DB::delete("DELETE FROM users WHERE id=?",[$id]);
        DB::delete("DELETE FROM role_user WHERE user_id=?",[$id]);
    }

}
