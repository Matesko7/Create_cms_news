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


<!----------------------------------VYBER STRANKY ------------------------->
<div class="input-group my-5 mx-auto" style="width:60%">
    <div class="input-group-prepend">
        <label class="input-group-text" style="height: 38px;" for="choosePage">Stránka</label>
    </div>
    <select class="custom-select" id="choosePage">
        @if(!$id)
            <option value="0" selected>Výber...</option>
        @endif
        @foreach($pages as $page)
            @if($id == $page->id)
                <option value="{{$page->id}}" selected>{{$page->name}}</option>
            @else
                <option value="{{$page->id}}" >{{$page->name}}</option>
            @endif
        @endforeach
    </select>

    <div class="text-center">
        <a href="{{asset('/admin/pages')}}" id="choosePageButton"><button type="button" class="btn btn-primary">Vybrať</button></a>
    </div>
</div>
<div class="text-center">
<form action="{{asset('/admin/pages/new')}}" method="post">
@csrf 
  Vytvoriť novú stránku: <input type="text" name="page_name" id="page_name" >
  <button type="submit" id="newPage" class="btn btn-primary">Uložiť</button>
</form>
</div>

<!----------------------------------VKLADANIE A EDITACIA KOMPONENTOV ------------------------->
@if($id)
<hr>
<h4 class="text-center">Názov editovanej stránky: <b>{{$page_name}}</b></h4>
<div class="row" style="max-width:100%">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 ">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" style="height: 38px;" for="insertComponents">Komponenty</label>
            </div>
            <select class="custom-select" id="insertComponents">
                <option value="0" selected>Výber...</option>
                @foreach($components as $component)
                <option value="{{$component->id}}">{{$component->name}}</option>    
                @endforeach
            </select>
        </div>
        <div class="text-center">
            <button type="button" id="insert" class="btn btn-primary">Vybrať</button>
        </div>
        <div class="input-group mx-auto my-3" style="width:60%;display:none" id="components_detail"></div>
        <div class="text-center" style="display:none" id="button_components_detail">
            <button type="button" id="insert_component_detail" class="btn btn-secondary">Vložiť</button>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 ">
        <ul id="sortable" style="border: 1px solid;">
            @foreach($page_components as $component)
                <li id="component_{{$component->id}}" class="ui-state-default" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$component->name}} @if($component->name2)<br /><small style="color:#0e0d3d;font-size: 60%;">{{$component->name2}} </small>@endif<button type="button" class="btn btn-danger  btn-sm float-right" id="delete_{{$component->id}}">Vymazať</button></li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!----------------------------------PRIRADOVANIE STRANOK K MENU ------------------------->
<hr>
<h4 class="text-center">Priraďovanie stránok</b></h4>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Stránka</th>
      <th scope="col">Položka v menu</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach($pages as $key => $page)
  <tr>
      <th scope="row">{{$key+1}}</th>
      <td>{{$page->name}}</td>
      <td>
        <div class="input-group" style="width:60%">
            <div class="input-group-prepend">
                <label class="input-group-text" style="height: 38px;" for="chooseItemFromMenu">Stránka</label>
            </div>
            <select class="custom-select" id="chooseItemFromMenu_{{$page->id}}">
                @if(!$page->menu_item_id)
                    <option value="0" selected>Výber...</option>
                @endif
                @foreach($menu_items as $item)
                    @if($page->menu_item_id == $item->id)
                        <option value="{{$item->id}}" selected>{{$item->label}}&nbsp({{$item->link}})</option>    
                    @else
                        <option value="{{$item->id}}">{{$item->label}}&nbsp({{$item->link}})</option>    
                    @endif
                @endforeach
            </select>

            <div class="text-center">
                <button id="buttonChooseItemFromMenu_{{$page->id}}" onclick="addMenuItemToPage(this)" type="button" class="btn btn-success">Uložiť</button>
            </div>
        </div>
      </td>
      <td><button type="button" class="btn btn-danger" onclick="delete_page({{$page->id}},'{{$page->name}}')">Vymazať stránku</button></td>
    </tr>
  @endforeach
  </tbody>
</table>

<script>
    $(function () {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    });
</script>

<script>
    $("#choosePage").change(function(){ 
        $("#choosePageButton").attr("href", "{{asset('admin/pages')}}" +'/'+$("#choosePage").val() );
    });

    $('#insertComponents').on('change', function() {
         $("#insertComponentDetailExact").remove();
         $("#insertComponentDetailExact_text").remove();
         $("#button_components_detail").hide();
    });

    //PRIDANIE KOMPONENTU NA STRANKU
    $("#insert").click(function(){
        if($("#insertComponents").val() == 0)
            return alert('Nebola zvolená žiadna možnosť');

        if($("#insertComponents").val() == 3 || $("#insertComponents").val() == 7 || $("#insertComponents").val() == 6  || $("#insertComponents").val() == 8 || $("#insertComponents").val() == 1  || $("#insertComponents").val() == 11 )
            return componentDetail($("#insertComponents").val());

        ajax_newComponentToPage($("#insertComponents").val());
    });

    //PRIDANIE PRESNEHO KOMPONENTU NA STRANKU
    $("#insert_component_detail").click(function(){
        if($("#insertComponentDetailExact").val() == 0)
            return alert('Nebola zvolená žiadna možnosť');
        
        if($("#insertComponentDetailExact").val() == "X")
            return ajax_newComponentToPage($("#insertComponents").val());
        
        ajax_newComponentToPage($("#insertComponents").val(),$("#insertComponentDetailExact").val());
    });

    function componentDetail(component_id){
        if( (component_id == 3 && {{sizeof($components_about)}} == 0) || (component_id == 7 && {{sizeof($components_gallery)}} == 0) || (component_id == 6 && {{sizeof($components_map)}} == 0) || (component_id == 1 && {{sizeof($components_carousel)}} == 0) || (component_id == 11 && {{sizeof($components_voting)}} == 0) )
            return alert("Pre daný typ komponentu neexistujú žiadne jeho varianty. Prejdite do sekcie komponenty a daný variant pre tento typ komponentu vytvorte.");

        $("#components_detail").show();
        $("#button_components_detail").show();
        plot= "<div class='input-group-prepend' id='insertComponentDetailExact_text'><label class='input-group-text' style='height: 38px;'>Konkrétny</label></div>";

        plot+="<select class='custom-select' id='insertComponentDetailExact'><option value='0' selected>Výber...</option>"
            if(component_id == 1){
                @foreach($components_carousel as $component)
                plot+= "<option value="+{{$component->id}}+">"+"{{$component->name}}"+"</option>"    
                @endforeach    
            }
            if(component_id == 3){
                @foreach($components_about as $component)
                plot+= "<option value="+{{$component->id}}+">"+"{{$component->name}}"+"</option>"    
                @endforeach    
            }
            if(component_id == 6){
                @foreach($components_map as $component)
                plot+= "<option value="+{{$component->id}}+">"+"{{$component->name}}"+"</option>"    
                @endforeach    
            }
            if(component_id == 7){
                @foreach($components_gallery as $component)
                plot+= "<option value="+{{$component->id}}+">"+"{{$component->name}}"+"</option>"    
                @endforeach    
            }
            if(component_id == 8){
                plot+= "<option value='X'>Všetky kategórie</option>"
                @if(!empty($components_articles))    
                    @foreach($components_articles as $component)
                    plot+= "<option value="+{{$component->id}}+">"+"{{$component->name}}"+"</option>"    
                    @endforeach
                @endif    
            }
            if(component_id == 11){
                @foreach($components_voting as $component)
                plot+= "<option value="+{{$component->id}}+">"+"{{$component->name}}"+"</option>"    
                @endforeach    
            }
        plot+= "</select>"
        $("#components_detail").append(plot);
        
    }

    //VYMAZANIE KOMPONENTU ZO STRANKY
    $("#sortable").on('click', 'li > button' ,function(){
        var id= this.id.split("_")[1];
        ajax_deleteComponentFromPage(id);
    });
    
    //ZMENA PORADIA KOMPONENTOV
    $( "#sortable" ).sortable({
        stop: function( ) {	
            var order = $("#sortable").sortable("serialize", {key:'id'});
            ajax_componentOrderChange(order)
        }
    });

    function delete_page(id, name){
        var r = confirm("Ste si istý že chcete vymazať celú stránku: "+name);
        if (r == true) {
            window.location.href = "{{asset('admin/pages/deletePage/')}}" +"/"+id;
        }
    }

    function addMenuItemToPage(e){
        var page_id= e.id.split("_")[1];
        var menuItem_id = $("#chooseItemFromMenu_"+page_id).val()
        if(menuItem_id == 0)
            return alert('Nebola zvolená žiadna položka z menu');
        window.location.href = "{{asset('admin/pages/addMenuItemToPage/')}}" +"/" + page_id + "/" + menuItem_id;
    }

    function ajax_newComponentToPage(component_id, component_detail_id=null){
        $.ajax({
            url: '{{asset("admin/pages/saveNewComponent")}}',
            data: {'page_id': "{{$id}}", 'component_id': component_id, 'component_detail_id': component_detail_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function ( res ) {
                if(res['status'] == "error"){
                    return alert(res['msg'])
                }

                var new_component = "<li id='component_"+res['msg']+"' class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>"+$("#insertComponents option:selected").text();
                if($("#insertComponentDetailExact option:selected").text() != "")
                    new_component += "<br><small style='color:#0e0d3d;font-size: 60%;'>"+$("#insertComponentDetailExact option:selected").text()+"</small>";
                
                new_component += "<button type='button' class='btn btn-danger  btn-sm float-right' id='delete_"+res['msg']+"'>Vymazať</button></li>";

                $("#sortable").append(new_component);
            }
        });
    }

    function ajax_deleteComponentFromPage(component_id){
        $.ajax({
            url: '{{asset("admin/pages/deleteComponent")}}',
            data: {'page_id': "{{$id}}", 'component_id': component_id},
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

    function ajax_componentOrderChange(order){
        $.ajax({
            url: '{{asset("admin/pages/changeOrderOfComponents")}}',
            data: {'page_id': "{{$id}}", 'order': order},
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
