<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\User;
Use App\Role;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function blockOrUnblock($action, $id){
        $obj_user = User::find($id);
        if($action === "unblock"){
            $message = 'Použivateľ '.$obj_user->email.' bol odblokovaný'; 
            $obj_user->blocked = 0;
            $obj_user->save();
        }else if($action === "block"){
            $message = 'Použivateľ '.$obj_user->email.' bol zablokovaný';
            $obj_user->blocked = 1;
            $obj_user->save();

        }else{
            return back();     
        }

        return back()->with('success', $message);
    }
    

    
    public function AdminEditPassword($id){
      if(!Auth::user()->hasRole('admin')){
        return abort(401, 'This action is unauthorized.');
      }
      $users= new User;
      return view('Admin/Users/admin_password_reset', ['user' => $users->getAll($id)]);
    }
    
    public function Adminchangepassword(Request $request,$id){
      if(!Auth::user()->hasRole('admin')){
        return abort(401, 'This action is unauthorized.');
      }

      $this->validate($request, [
        'newpassword' => 'required',
        'newpasswordconfirm' => 'required',
      ]);
      
      $users= new User;
      $user = $users->getAll($id);
      
      if ($request->newpassword !== $request->newpasswordconfirm ) {
        return back()->with('error','Nové heslo sa nezhoduje s potvrdzujúcim');
      }

      $obj_user = User::find($id);
      $obj_user->password = Hash::make($request->newpassword);
      $obj_user->save();
      
      return redirect(asset('/admin/users'))->with('success','Heslo použivateľa '.$obj_user->email.' úspešne zmenené');  
    }

    public function editPassword($id){
        if(Auth::user()->id!=$id && !Auth::user()->hasRole('admin')){
          return abort(401, 'This action is unauthorized.');
        }
    
        $users= new User;
        return view('Admin//Users/user_password_change', ['user' => $users->getAll($id)]);
      }

    public function changepassword(Request $request,$id){
      if(Auth::user()->id!=$id && !Auth::user()->hasRole('admin')){
        return abort(401, 'This action is unauthorized.');
      }

      $this->validate($request, [
        'oldpassword' => 'required',
        'newpassword' => 'required',
        'newpasswordconfirm' => 'required',
      ]);
      
      $users= new User;
      $user = $users->getAll($id);
      
      if (!Hash::check($request->oldpassword, $user[0]->password)) {
        return back()->with('error','Pôvodne heslo je nespravne');
      }
      
      if ($request->newpassword !== $request->newpasswordconfirm ) {
        return back()->with('error','Nové heslo sa nezhoduje s potvrdzujúcim');
      }

      
      $user_id = Auth::User()->id;                       
      $obj_user = User::find($user_id);
      $obj_user->password = Hash::make($request->newpassword);
      $obj_user->save();
      
      Auth::login($obj_user);
      return redirect(asset('/profile'))->with('success','Heslo úspešne zmenené');  
    }

    public function edit($id = null){

      $role= new Role;
      $roles=Role::all();

      if($id==null){
        return view('Admin/Users/user_new');    
      }else{
        $users= new User;
        $user_role=$role->getRoleByUserID($id);
        $user_photo=false;
        $photo= glob("users/$id/*"); // get all file names
        foreach($photo as $value){ // iterate files
            if(is_file($value))
                $user_photo=$value;
        }
        return view('Admin/Users/user_detail', ['user' => $users->getAll($id),'roles' => $roles,'user_role' => $user_role, 'user_photo' => $user_photo]);
      }
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
