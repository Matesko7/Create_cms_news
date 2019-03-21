<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\User;
Use App\Role;
use Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(){
        $users= new User;
        return view('Admin/Users/users', ['users' => $users->getAll()]);
    }

    public function editprofile(Request $request,$id){
        if(Auth::user()->id!=$id && !Auth::user()->hasRole('admin'))
            return abort(401, 'This action is unauthorized.');
        
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('danger','Invalid email format'); 
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        
        $user= new User;
        //ulozenie nahrateho suboru
        $file = $request->file('file');

        if(isset($file)){
            $photos= glob("users/$id/*"); // get all file names
            foreach($photos as $value){ // iterate files
                if(is_file($value))
                    unlink($value);
            }
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $size= $_FILES['file']['size'];
            $file->move(base_path('public/users/'.$id),$id.'.'.$path_parts['extension']);
        }
        
        if(Auth::user()->hasRole('admin') && Auth::user()->id!=$id)
            $user->updateNameEmail($request->name,$request->email,$id,$request->role);
        else $user->updateNameEmail($request->name);

        return back()->with('success','Profil aktualizovaný');

    }

    public function edit($id){
        $users= new User;
        $role= new Role;
        $roles=Role::all();
        $user_role=$role->getRoleByUserID($id);
        $user_photo=false;
        $photo= glob("users/$id/*"); // get all file names
        foreach($photo as $value){ // iterate files
            if(is_file($value))
                $user_photo=$value;
        }  
        return view('Admin//Users/user_detail', ['user' => $users->getAll($id),'roles' => $roles,'user_role' => $user_role, 'user_photo' => $user_photo]);
    }

    public function delete($id){
        $user= new User;
        $user->deleteUser($id);
        $photos= glob("users/$id/*"); // get all file names
        foreach($photos as $value){ // iterate files
            if(is_file($value))
                unlink($value);
        }
        if (is_dir("users/$id")) {
            rmdir("users/$id");
        }
        return back()->with(['success' => 'Uživateľ úspešne zmazaný','users' => $user->getAll()]);
    }
}
