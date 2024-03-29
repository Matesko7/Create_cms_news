@extends('layout.app_admin')

@section('content')
    {{ Form::open(array('url' => isset($option) ? asset("admin/option/".$option->id): asset('admin/option') ,'files' => true)) }}
        <div style="padding:50px;" class="row">
            <!-- edit form column -->
            <div class="col-md-12 personal-info">
                <div class="form-group">
                    <label class="col-lg-4 control-label">Parameter nastavenia:</label>
                    <div class="col-lg-8">
                        <select onchange="option_type_change()" id="options_type" name="options_type" class="form-control">
                            @foreach($options as $key=>$value)
                            @if(isset($option) && $value->id == $option->type_id)
                                <option name="option_type" value="{{$value->id}}" selected>{{$value->name}}</option>
                            @else
                                <option name="option_type" value="{{$value->id}}">{{$value->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" id="email_newsletter" style="display:none">
                    <label class="col-lg-3 control-label">email:</label>
                    <div class="col-lg-8">
                        @if(isset($option))
                        <input class="form-control" id="email" name="email" type="text" value="{{explode('||', $option->value)[0]}}">
                        @else
                        <input class="form-control" id="email" name="email" type="text" placeholder="hodnota" value="">
                        @endif
                    </div>
                    <label class="col-lg-3 control-label">alias:</label>
                    <div class="col-lg-8">
                        @if(isset($option))
                        <input class="form-control" id="email_alias" name="email_alias" type="text" value="{{ count(explode('||', $option->value)) > 1 ?  explode('||', $option->value)[1] : $option->value}}">
                        @else
                        <input class="form-control" id="email_alias" name="email_alias" type="text" placeholder="alias" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group" id="bacis_param" style="display:none">
                    <label class="col-lg-3 control-label">Hodnota parametra:</label>
                    <div class="col-lg-8">
                        @if(isset($option))
                        <input class="form-control" id="option_value1" name="option_value1" type="text" value="{{$option->value}}">
                        @else
                        <input class="form-control" id="option_value1" name="option_value1" type="text" placeholder="hodnota" value="">
                        @endif
                    </div>
                </div>

                <div class="form-group" id="meta_tags" style="display:none">
                    <label class="col-lg-3 control-label">Hodnota parametra:</label>
                    <div class="col-lg-12" style="display:flex">
                        @if(isset($option) && $option->type_id==4)
                        <div class="col-md-4">
                            <div style="display:inline-block" class="ui-select">
                                <select id="meta_options_type" name="meta_options_type" class="form-control">
                                    @if(explode('||', $option->value)[0] == "name")
                                        <option  value="name" selected>name</option>
                                        <option  value="property">property</option>
                                    @else
                                        <option  value="name">name</option>
                                        <option  value="property" selected>property</option>
                                    @endif
                                </select>
                            </div>
                            <div style="display:inline-block" class="ui-select">    
                                <input class="form-control" id="option_value_meta" name="option_value_meta" type="text" value="{{explode('||', $option->value)[1]}}">
                            </div>
                        </div>
                        <div class="col-md-4"><label>Content</label>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value_content_meta" name="option_value_content_meta" type="text" value="{{explode('||', $option->value)[2]}}">
                            </div>
                        </div>
                        @else
                        <div class="col-md-4">
                            <div style="display:inline-block" class="ui-select">
                                <select id="meta_options_type" name="meta_options_type" class="form-control">
                                        <option  value="name">name</option>
                                        <option  value="property" >property</option>
                                </select>
                            </div>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value_meta" name="option_value_meta" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-4"><label>Content</label>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value_content_meta" name="option_value_content_meta" type="text" value="">
                            </div>
                        </div>
                        @endif
                    </div>
                </div> 

                <div class="form-group" id="link_tags" style="display:none">
                    <label class="col-lg-3 control-label">Hodnota parametra:</label>
                    <div class="col-lg-12" style="display:flex">
                        @if(isset($option) && $option->type_id==8)
                        <div class="col-md-4"><label>rel</label>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value" name="option_value" type="text" value="{{explode('||', $option->value)[1]}}">
                            </div>
                        </div>
                        <div class="col-md-4"><label>href</label>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value_content" name="option_value_content" type="text" value="{{explode('||', $option->value)[2]}}">
                            </div>
                        </div>
                        @else
                        <div class="col-md-4"><label>rel</label>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value" name="option_value" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-4"><label>href</label>
                            <div style="display:inline-block" class="ui-select">
                                <input class="form-control" id="option_value_content" name="option_value_content" type="text" value="">
                            </div>
                        </div>
                        @endif
                    </div>
                </div> 

                <div class="form-group" id="page_style" style="display:none">
                    <label class="col-lg-3 control-label">Typ šablóny:</label>
                    <div style="display:inline-block" class="ui-select">
                        <select id="page_style_type" name="page_style_type" class="form-control">
                                <option  value="1" {{(isset($option) && $option->type_id == 9 && $option->value == 1) ? 'selected' : ''}} >Header - Center - Footer</option>
                                <option  value="2" {{(isset($option) && $option->type_id == 9 && $option->value == 2) ? 'selected' : ''}} >Header - Center(L-M-R) - Footer</option>
                                <option  value="3" {{(isset($option) && $option->type_id == 9 && $option->value == 3) ? 'selected' : ''}} >Header - Center(L-R) - Footer</option>
                        </select>
                    </div>
                </div> 


                <button id="new_cat_save" name="new_cat_save" class="btn btn-info show-more">Uložiť</button>
    {{ Form::close() }}
</div>
</div>

<script>
var option_id = "{{isset($option) ? $option->type_id : '' }}"

if( option_id == 4){
    $('#meta_tags').show();
}else if( option_id == 6){
    $('#email_newsletter').show();
}else if( option_id == 8){
    $('#link_tags').show();
}else if( option_id == 9){
    $('#page_style').show();
}else{
    $('#bacis_param').show();
}

function option_type_change(){
    $('#link_tags').hide();
    $('#meta_tags').hide();
    $('#bacis_param').hide();
    $('#email_newsletter').hide();
    $('#page_style').hide();

    var type_id = $('#options_type').val();
    if(type_id == 4){
        $('#meta_tags').show();
    }
    else if(type_id == 6){
        $('#email_newsletter').show();
    }
    else if(type_id == 8){
        $('#link_tags').show();
    }
    else if(type_id == 9){
        $('#page_style').show();
    }
    else{
        $('#bacis_param').show();
    }
    
}

</script>

@endsection
