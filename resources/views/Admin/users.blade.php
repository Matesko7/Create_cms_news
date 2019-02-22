@extends('layout.app')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Uživatelia</h2>
    </div>
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
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
                                <a href="/admin/user/{{$user->id}}">
                                    <i title="upraviť"
                                    class="fas fa-pencil-alt pen"></i>
                                </a>&nbsp&nbsp&nbsp&nbsp
                                <a href="/admin/deleteuser/{{$user->id}}">
                                    <i title="vymazať" class="fas fa-trash bin"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
