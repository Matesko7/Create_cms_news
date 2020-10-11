@extends('layout.app_admin')

@section('content')
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
            <form class="form-horizontal" enctype="multipart/form-data" true method="POST" action="{{asset('/admin/passwordChange/'.$user[0]->id)}}">@csrf
                <div style="padding:50px;" class="row">
                    <!-- edit form column -->
                    <div class="col-md-12 personal-info">
                        <h3>Zmena hesla použivateľa: {{$user[0]->email}}</h3>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Nové heslo:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="newpassword" name="newpassword" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Potvrdenie nového hesla:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="newpasswordconfirm" name="newpasswordconfirm" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input type="submit" class="btn btn-info show-more" value="Uložiť zmeny">
                            </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
