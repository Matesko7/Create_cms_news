@extends('layout.app_admin')
@section('content')
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 80%;
    }

    #sortable li {
        margin: 0 3px 3px 3px;
        padding: 0.2em;
        padding-left: 1.5em;
        font-size: 1.2em;
    }

    #sortable li span {
        position: absolute;
        margin-left: -1.3em;
    }

    .flex-container {
        display: flex;
    }

    .flex-container>div {
        background-color: #f1f1f1;
        margin: 10px;
        padding: 20px;
        width: 40%;
    }
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<form action="{{asset('/admin/voting/saveNewQuestion/'.$component[0]->id)}}" method="post">
    @csrf 
    <h4 class="text-center" style="margin-top:20px">Otázka:</h4>
    <div style="text-align: center">
        <textarea rows="1" cols="50" name="question" id="question">@if(isset($content[0]->question)){{$content[0]->question}}@endif</textarea>
    </div>
    <div class="text-center">Popis( nepovinné pole)</div>
    <div style="text-align: center">
        <textarea rows="1" cols="30" name="description" id="description">@if(isset($content[0]->description)){{$content[0]->description}}@endif</textarea>
    </div>
    <div style="text-align: center">
        <button type="submit" id="newPage" class="btn btn-primary">Uložiť</button>
    </div>
</form>
<hr>
@if(isset($content[0]))
<h4 class="text-center">Možnosti odpovede</h4>
<div class="row" style="max-width:100%">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 ">
        <div class="input-group mb-3">
            Nová možnosť: &nbsp
            <input type="text" name="new_option" id="new_option">
        </div>
        <div class="text-center">
            <button type="button" id="insert" class="btn btn-primary">Vložiť</button>
        </div>
        
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 ">
        <ul id="sortable" style="border: 1px solid;">
        @if(isset($content['options']))
            @foreach($content['options'] as $option)
                <li id="component_{{$option->id}}" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$option->value}} <button type="button" class="btn btn-danger  btn-sm float-right" id="delete_{{$option->id}}">Vymazať</button></li>
            @endforeach
        @endif
        </ul>
    </div>
</div>
<hr>
<h4>Výsledky hlasovania</h4>
    @if($content['votes'][0]->votes_all != 0)
    Hlasov dokopy: <b>{{$content['votes'][0]->votes_all}}</b>
    <ol>
        @if(isset($content['options']))
            @foreach($content['options'] as $option)
                <li>{{$option->value}} &nbsp &nbsp hlasy: {{$option->votes_number}} &nbsp &nbsp podiel: <b>{{($option->votes_number/$content['votes'][0]->votes_all)*100}}%</b></li>
            @endforeach
        @endif
    </ol> 
    @else
        Hlasovanie sa ešte nezačalo (žiadny hlasujúci)
    @endif
@endif


<script>
//PRIDANIE MOZNOSTI
$("#insert").click(function(){
    if($("#new_option").val() == "")
        return alert('Možnosť nemôže býť prázdna');

    ajax_newOption($("#new_option").val());
});

//VYMAZANIE MOZNOSTI
$("#sortable").on('click', 'li > button' ,function(){
    var id= this.id.split("_")[1];
    ajax_deleteOption(id);
});

//ZMENA PORADIA KOMPONENTOV
$( "#sortable" ).sortable({
    stop: function( ) {	
        var order = $("#sortable").sortable("serialize", {key:'id'});
        console.log(order);
        ajax_optionsOrderChange(order)
    }
});


function ajax_newOption(value){
    const id = "{{ isset($content[0]->id) ? $content[0]->id : ""}}";
    $.ajax({
        url: '{{asset("admin/voting/saveNewOption")}}',
        data: {'question_id': id, 'value': value},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        success: function ( res ) {
            if(res['status'] == "error"){
                return alert(res['msg'])
            }
            var new_component = "<li id='component_"+res['msg']+"' class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>"+value+"<button type='button' class='btn btn-danger  btn-sm float-right' id='delete_"+res['msg']+"'>Vymazať</button></li>";
            $("#sortable").append(new_component);
        }
    });
}

function ajax_deleteOption(component_id){
    const id = "{{ isset($content[0]->id) ? $content[0]->id : ""}}";
    $.ajax({
        url: '{{asset("admin/voting/deleteOption")}}',
        data: {'option_id': component_id, 'question_id': id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        success: function ( res ) {
            if(res['status'] == "error"){
                return alert(res['msg'])
            }

            $("#component_"+component_id).remove();
        }
    });
}

function ajax_optionsOrderChange(order){
    $.ajax({
        url: '{{asset("admin/voting/changeOrderOfOptions")}}',
        data: {'order': order},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        success: function () {
        }
    });
}      

</script>

@endsection