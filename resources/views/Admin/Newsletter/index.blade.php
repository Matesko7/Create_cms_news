@extends('layout.app_admin')
@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .active {
        background-color: white;
        color: black;
    }
    </style>
</head>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Odoberatelia</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Emaily</a>
  </li>
  </ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row" style="margin-left:0px; margin-right: 0px;">
            <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
                <div style="font-size: 18px; font-weight: 400;color: fff;">
                        Celkový počet odoberatelov: {{$subscribers_numbers['all']}}<br>
                        Aktívny odoberatelia: {{$subscribers_numbers['active']}}<br>
                        Neaktívny odoberatelia: {{$subscribers_numbers['inActive']}}
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Stav</th>
                                <th scope="col">Akcie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscribers as $key => $subscriber)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td>{{$subscriber->email}}</td>
                                <td>{{$subscriber->subscribe == 1 ? 'Odoberá' : 'Neodoberá' }}</td>
                                <td>
                                    @if($subscriber->subscribe == 1)
                                        <a href="{{asset("admin/deleteSubscriber/$subscriber->id")}}">
                                            <button type="button" class="btn btn-danger btn-sm">Zrušit uživateľovy odber</button>
                                        </a>
                                    @else
                                        <a href="{{asset("admin/refreshSubscriber/$subscriber->id")}}">
                                            <button type="button" class="btn btn-primary btn-sm">Obnoviť uživateľovy odber</button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <a href="{{asset('admin/email')}}"><div class="new-article btn">Pridať nový &nbsp<i class="fas fa-plus"></i></div></a>
        
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row" style="margin-left:0px; margin-right: 0px;">
                <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
                    <div style="font-size: 18px; font-weight: 400;color: fff;">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emails as $key => $email)
                                <tr>
                                    <th scope="row">{{$key + 1}}</th>
                                    <td>{{$email->subject}}</td>
                                    <td>
                                        <button type="button"   onclick="setEmailId({{$email->id}})" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Odoslať testovaci email</button>&nbsp&nbsp&nbsp&nbsp
                                        <button type="button" onclick="confirmation({{$email->id}})" class="btn btn-success">Odoslať Newsletter</button>&nbsp&nbsp&nbsp&nbsp
                                        <a href="{{asset("admin/email/$email->id")}}">
                                            <i title="upraviť" class="fas fa-pencil-alt pen"></i>
                                        </a>&nbsp&nbsp&nbsp&nbsp
                                        <a href="{{asset("admin/deleteEmail/$email->id")}}">
                                            <i title="vymazať" class="fas fa-trash bin"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
                {{ $emails->links() }}
            </div>
        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Odoslanie testovacieho emailu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <p>Zadajte adresu pre testovací email</p>
        <input value="" type="text" class="form-control" name="email_test" id="email_test" placeholder="example@gmail.com">
        <br><br><div class='alert alert-success' id="alert_modal" role='alert'>Testovací email úspešne odoslaný</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavrieť</button>
        <button type="button" onclick="ajax_sendTestEmail()" class="btn btn-primary">Odoslať</button>
      </div>
    </div>
  </div>
</div>

<script>

var email_id = ""

function setEmailId(id){
    email_id= id ;
    $("#alert_modal").hide()
}


function confirmation(id) {
  var txt;
  var r = confirm("Naozaj chcete odoslať Newsletter všetkym odoberatelom ?");
  if (r == true) 
    window.location.href = "{{asset('admin/sendEmail')}}"+'/'+id;
}

function ajax_sendTestEmail(){
    if( !$("#email_test").val() ){
        alert('Pole email nebolo vyplnené');
        return;
    }
    $.ajax({
        url: '{{asset("admin/sendTestEmail")}}',
        data: {'email_id': email_id, 'email': $("#email_test").val() },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        success: function ( res ) {
            $("#alert_modal").show()
            setTimeout(function() { 
                $('#exampleModal').modal('toggle');
            }, 2000);
        }
    });
    //
}


</script>

@endsection
