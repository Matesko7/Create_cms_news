@extends('layout.app_admin')

@section('content')
<div class="m-5">
<form action="{{asset('admin/component/edit/articles/'.$component[0]->id)}}" enctype="multipart/form-data" method="POST">
@csrf
  <div class="form-group">  
    <label >Kategória</label>
    <div class="col-lg-8">
        <select id="category_option" name="category_option" class="form-control">
            @foreach($categories as $key=>$category)
                    @if( isset($content[0]->category_id) && $category->id == $content[0]->category_id)
                        <option name="option" value="{{$category->id}}" selected>{{$category->name}}</option>
                    @else
                        @if($category->id != 1)
                            <option name="option" value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endif
            @endforeach
        </select>
    </div>
   </div> 
  <div class="text-center">
    <button type="submit" class="btn btn-lg btn-primary">Uložiť</button>
  </div>
</form>
</div>
@endsection