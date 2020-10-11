@extends('layout.app_admin')
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('jodit/build/jodit.min.css')}}">
    <script src="{{asset('jodit/build/jodit.min.js')}}"></script>
</head>

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
    <textarea name="editor" id="editor"></textarea>
  </div>
  <div class="text-center">
    <button type="submit" class="btn btn-lg btn-primary">Uložiť</button>
  </div>
</form>
</div>


<script>
var editor=new Jodit('#editor', {
    enableDragAndDropFileToEditor: true,
    height: 500
});

    var z = "{{ isset($email->body) ? $email->body : '' }}";
        
    z = z.replace(/&lt;/g, "<");
    z = z.replace(/&amp;/g, "&");
    z = z.replace(/&gt;/g, ">");
    z = z.replace(/&quot;/g, '"');
    z = z.replace(/&#039;/g, "'");
    editor.value = z;
</script>
@endsection