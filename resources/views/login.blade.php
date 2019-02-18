@extends('layout.app')

@section('content')
<div class="container">
    <div class="row" style="margin: 0 250px 0 250px;">
        @include('inc.messages')
        {{ Form::open(array('url' => '/login/checklogin','autocomplete' => 'off','style'=>"width:100%"))}}
        {{csrf_field()}}
        <div class="form-row">
            <div class="form-group col-md-6 container text-center">
                <input type="email" class="form-control" name="e-mail" value="admin@admin.sk" required>
                <label for="e-mail">E-mail</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 container text-center">
                <input type="password" value="123" class="form-control" name="password" required>
                <label for="password">Heslo</label>
            </div>
        </div>
        <div class="form-row" style="text-align: center;">
            <div class="col text-center">
                <input type="submit" name="Odoslať" class="btn">
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

@endsection
