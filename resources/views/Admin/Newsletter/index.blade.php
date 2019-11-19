@extends('layout.app_admin')
@section('content')
<head>
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
                                    <a href="{{asset("admin/deleteSubscriber/$subscriber->id")}}">
                                    <i title="vymazať" class="fas fa-trash bin"></i>
                                    </a>
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
                                        <button type="button" onclick="confirmation({{$email->id}})" class="btn btn-success">Odoslať email</button>&nbsp&nbsp&nbsp&nbsp
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

<script>
function confirmation(id) {
  var txt;
  var r = confirm("Naozaj chcete odoslať email všetkym odoberatelom ?");
  if (r == true) 
    window.location.href = "{{asset('admin/sendEmail')}}"+'/'+id;
}
</script>

@endsection
