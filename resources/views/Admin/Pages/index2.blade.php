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

<div class="text-center">
<form action="{{asset('/admin/pages/new')}}" method="post">
@csrf 
  Vytvoriť novú stránku: <input type="text" name="page_name" id="page_name" >
  <button type="submit" id="newPage" class="btn btn-primary">Uložiť</button>
</form>
</div>
<!----------------------------------PRIRADOVANIE STRANOK K MENU ------------------------->
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Názov</th>
      <th scope="col">Priradená url k stranke</th>
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
                <label class="input-group-text" style="height: 38px;" for="chooseItemFromMenu">URL</label>
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
      <td>
        <a href="{{asset("/admin/pages/edit/$page->id")}}">
            <i title="upraviť" class="fas fa-pencil-alt pen"></i>
        </a>&nbsp&nbsp&nbsp&nbsp
        <a href="{{asset("/admin/pages/delete/$page->id")}}">
            <i title="vymazať" class="fas fa-trash bin"></i>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>


<script>
    function addMenuItemToPage(e){
        var page_id= e.id.split("_")[1];
        var menuItem_id = $("#chooseItemFromMenu_"+page_id).val()
        if(menuItem_id == 0)
            return alert('Nebola zvolená žiadna položka z menu');
        window.location.href = "{{asset('admin/pages/addMenuItemToPage/')}}" +"/" + page_id + "/" + menuItem_id;
    }
</script>
@endsection
