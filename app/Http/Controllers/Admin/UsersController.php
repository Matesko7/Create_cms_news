<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\User;
use Auth;

class UsersController extends Controller
{
    public function index(){
        $users= new User;
        return view('Admin/users', ['users' => $users->getAll()]);
    }

    public function editprofile(Request $request,$id){
        if(Auth::user()->id!=$id)
            return abort(401, 'This action is unauthorized.');
        
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('danger','Invalid email format'); 
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        
        //ulozenie nahrateho suboru
        $file = $request->file('file');

        if(isset($file)){
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $size= $_FILES['file']['size'];
            $file->move(base_path('public/users'),$id.'.'.$path_parts['extension']);
        }

        $user= new User;
        $user->updateNameEmail($request->name,$request->email);
        
        return back()->with('success','Profil aktualizovaný');

    }

    public function edit($id){
        $users= new User;
        return view('Admin/user_detail', ['user' => $users->getAll($id)]);
    }

    public function delete($id){
        $articles= new Article;
        $articles->deleteArticle($id);
        return back()->with(['success' => 'Článok úspešne zmazaný','articles' => $articles->getAll()]);
    }
}
