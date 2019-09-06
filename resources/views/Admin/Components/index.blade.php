@extends('layout.app_admin')

@section('content')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
small:hover {
    cursor: pointer;
}
</style>

    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
        <a href="{{asset('admin/component')}}"><div class="new-article btn">Pridať nový &nbsp<i class="fas fa-plus"></i></div></a>
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Typ komponentu</th>
                            <th scope="col">Názov komponentu</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($components as $component)
                        <tr>
                            <th scope="row">{{$component->type}}</th>
                            <td style="max-width:250px;overflow:hidden;text-overflow: ellipsis;"><span id="component_name_{{$component->id}}">{{$component->name}}</span>
                                    <small id="change_name" style="margin-left:5px;padding: 2px 10px"><i id="pen_{{$component->id}}" onclick="rename({{$component->id}},'pen')" title="upraviť"
                                        class="fas fa-pencil-alt pen">
                                    </i><button onclick="rename({{$component->id}},'button')" id="button_{{$component->id}}" type="button" class="btn btn-primary" style="display:none">Uložiť</button></small></td>
                            <td style="min-width:80px">
                                <a href="{{asset('admin/components/edit/'.$component->id)}}">
                                    <i title="upraviť"
                                        class="fas fa-pencil-alt pen">
                                    </i>
                                </a> &nbsp&nbsp&nbsp&nbsp
                                <a href="{{asset('admin/components/delete/'.$component->id)}}">
                                    <i title="vymazať" class="fas fa-trash bin">
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    function rename(id,element){
        if( $("#component_name_"+id).html() == "")
                return alert('Názov komponentu nemože byť prázdny');

        $("#button_"+id).is(":hidden") ? $("#button_"+id).show() : $("#button_"+id).hide();
        $("#pen_"+id).is(":hidden") ? $("#pen_"+id).show() : $("#pen_"+id).hide();
        
        if(element == "pen"){
            $("#component_name_"+id).attr('contenteditable','true');
            $("#component_name_"+id).css({'background-color':'white','padding' : "5px 10px",'border' : "1px solid"});
        }
        else {
            ajax_rename_component(id);
            $("#component_name_"+id).attr('contenteditable','false');
            $("#component_name_"+id).css({'background-color':'inherit','padding' : "0px",'border' : "none"});
        }
    }

    function ajax_rename_component(id){
        $.ajax({
            url: '{{asset("admin/component_rename")}}',
            data: {'component_id': id, 'new_name': $("#component_name_"+id).html() },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function ( res ) {
                if(res['status'] == "error"){
                    return alert(res['msg'])
                }
            }
        });
    }   

</script>

@endsection
