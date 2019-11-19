@extends('layout.app_admin')
@section('content')
<div class="m-5">
<form action="{{$email ? asset('admin/email/'.$email->id) : asset('admin/email/') }}" enctype="multipart/form-data" method="POST">
@csrf
  <div class="form-group">
    <label >Predmet</label>
    <input value="{{$email ? $email->subject : ''}}" type="text" class="form-control" name="subject" id="subject" placeholder="Predmet emailu">
  </div>
  <div class="form-group">
    <label>Obsah</label>
    <textarea class="form-control" name="body" id="body" rows="5" placeholder="Obsah emailu...">@if(isset($email->body)){{$email->body}}@endif</textarea>
  </div>
  <div class="text-center">
    <button type="submit" class="btn btn-lg btn-primary">Uložiť</button>
  </div>
</form>
</div>
@endsection