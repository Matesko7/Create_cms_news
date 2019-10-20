@extends('layout.app_admin')

@section('content')
<div class="m-5">
<form action="{{asset('admin/component/edit/map/'.$component[0]->id)}}" enctype="multipart/form-data" method="POST">
@csrf
  <div class="form-group">
    <label >latitude</label>
    <input value="{{$content ? $content[0]->latitude: ''}}" type="text" class="form-control" name="latitude" id="latitude" placeholder="48.1834461513518">
  </div>
  <div class="form-group">
    <label >longitude</label>
    <input value="{{$content ? $content[0]->longitude: ''}}" type="text" class="form-control" name="longitude" id="longitude" placeholder="17.099425792694092">
  </div>
  <div class="form-group">
    <label>Text</label>
    <textarea class="form-control" name="text" id="text" rows="5">{{$content ? $content[0]->text: ''}}</textarea>
  </div>
  <div class="form-group">
    @if($content && $content[0]->link != "")
     <img width="200px" src="{{asset($content[0]->link)}}"><br>
    @endif
    <label for="exampleFormControlFile1">Obrázok</label>
    <input type="file" class="form-control-file"  id="file" name="file" accept="image/*">
  </div>
  <div class="text-center">
    <button type="submit" class="btn btn-lg btn-primary">Uložiť</button>
  </div>
</form>
</div>
@endsection