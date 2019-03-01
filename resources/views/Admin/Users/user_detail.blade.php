@extends('layout.app')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Editácia profilu</h2>
    </div>
    <hr>
    <form class="form-horizontal" enctype="multipart/form-data" true method="POST" action="{{asset("user/".$user[0]->id)}}" >@csrf
        <div style="padding:50px;" class="row">
            <!-- left column -->
            <div class="col-md-4">
                <div class="text-center">
                    <?php if(file_exists("users/".$user[0]->id.".jpg")){?>
                    <img src="{{asset("users/".$user[0]->id.".jpg")}}" class="avatar img-circle" alt="avatar">
                    <?php }else{ ?>
                    <img src="{{asset("users/Unknown_Person.png")}}" class="avatar img-circle" alt="avatar">
                    <?php } ?>
                    <br><br>
                    <input name="file" id="file" type="file" accept="image/x-png,image/jpeg" />
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-8 personal-info">
                <h3>Osobné informácie</h3>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Meno:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="name" name="name" type="text" value="{{$user[0]->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="email" name="email" type="text" value="{{$user[0]->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Rola:</label>
                    <div class="col-lg-8">
                        <div class="ui-select">
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $role)
                                @if($role->id==$user_role[0]->role_id)
                                    <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                @else
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn" value="Uložiť zmeny">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Zruš">
                    </div>
                </div>
    </form>
</div>
</div>
</div>
<hr>
@endsection
