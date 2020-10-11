@extends('layout.app_admin')

@section('content')
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
          <a href="{{asset('admin/user')}}"><div class="new-article btn">Pridať použivateľa &nbsp<i class="fas fa-plus"></i></div></a>
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Meno</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rola</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->name}}</th>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            <td>
                                <a href="{{asset("admin/user/$user->id")}}">
                                    <i title="upraviť"
                                    class="fas fa-pencil-alt pen"></i>
                                </a>&nbsp&nbsp&nbsp&nbsp
                                <a href="{{asset("admin/passwordChange/$user->id")}}">
                                    <i title="zmena hesla" style="color:Gold" class="fas fa-key"></i>
                                </a>
                                &nbsp&nbsp&nbsp&nbsp
                                @if($user->blocked === 0)
                                    <a href="{{asset("admin/user/block/$user->id")}}">
                                        <i title="zablokovať použivateľa" style="color:Tomato" class="fas fa-user-minus"></i>
                                    </a>
                                @else
                                    <a href="{{asset("admin/user/unblock/$user->id")}}">
                                        <i title="odblokovať použivateľa" style="color:green" class="fas fa-user-plus"></i>
                                    </a>
                                @endif
                                &nbsp&nbsp&nbsp&nbsp
                                <a href="{{asset("admin/deleteuser/$user->id")}}">
                                    <i title="vymazať" style="color:red" class="fas fa-trash bin"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
