
@extends('layout.app_admin')

@section('content')
<div class="m-5">
<form action="{{asset('admin/component/edit/about/'.$component[0]->id)}}" enctype="multipart/form-data" method="POST">
@csrf
<div class="form-group">
    <label >Nadpis</label>
    <input value="{{$content ? $content[0]->title: ''}}" type="text" class="form-control" name="title" id="title" placeholder="Letná prevádzka a prevádzkový predpis">
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