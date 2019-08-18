@extends('layout.app_admin')

@section('content')
    {{ Form::open(array('url' => asset('admin/component') ,'files' => true)) }}
        <div style="padding:50px;" class="row">
            <!-- edit form column -->
            <div class="col-md-8 personal-info">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Názov:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="name" name="name" type="text" placeholder="Názov komponentu" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Typ komponentu</label>
                    <div class="col-lg-8">
                        <select id="component_type" name="component_type" class="form-control">
                            @foreach($components as $key=>$component)
                                    <option name="component_option" value="{{$component->id}}">{{$component->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button id="new_cat_save" name="new_cat_save" class="btn btn-primary">Uložiť</button>
    {{ Form::close() }}
</div>
</div>

@endsection
