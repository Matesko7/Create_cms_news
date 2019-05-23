@extends('layout.app_admin')

@section('content')
<div class="container">
    {{ Form::open(array('url' => isset($category) ? asset("admin/category/".$category->id): asset('admin/category') ,'files' => true)) }}
        <div style="padding:50px;" class="row">
            <!-- edit form column -->
            <div class="col-md-8 personal-info">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Názov:</label>
                    <div class="col-lg-8">
                        @if(isset($category))
                        <input class="form-control" id="name" name="name" type="text" value="{{$category->name}}">
                        @else
                        <input class="form-control" id="name" name="name" type="text" placeholder="Názov kategórie" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Názov EN:</label>
                    <div class="col-lg-8">
                        @if(isset($category))
                        <input class="form-control" id="name_en" name="name_en" type="text" value="{{$category->name_en}}">
                        @else
                        <input class="form-control" id="name_en" name="name_en" type="text" placeholder="Category name" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Parent kategória:</label>
                    <div class="col-lg-8">
                        <select id="cat_parent" name="cat_parent" class="form-control">
                            @if(isset($category->parent_id))
                                    <option name="cat_parent" value="{{$category->parent_id}}" selected>{{$category->parent}}</option>
                                    <option value="1">-Nadradená kategória-</option>
                            @else
                                    <option value="1" selected>-Nadradená kategória-</option>
                            @endif
                            
                            @foreach($categories as $key=>$cat)
                                @if($cat->id!=1)
                                    <option name="cat_parent" value="{{$cat->id}}">{{$cat->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <button id="new_cat_save" name="new_cat_save" class="btn btn-info show-more">Uložiť</button>
    {{ Form::close() }}
</div>
</div>
</div>

@endsection
