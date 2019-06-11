@extends('layout.app_admin')

@section('content')


<head>
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('jodit/build/jodit.min.css')}}">
    <script src="{{asset('jodit/build/jodit.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>    

<style>
.nav {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none
}

.nav>li {
    position: relative;
    display: block
}

.nav>li>a {
    position: relative;
    display: block;
    padding: 10px 15px;
    cursor: pointer;
    background-color: #fff;
    border: 1px solid #ddd;
    border-bottom-color: transparent
}
</style>
<div class="container">
<br>
<ul class="nav nav-tabs">
  <li><a style="@if($lang=='sk')background-color:#C9D2E0 @endif" href="{{asset('admin/article/sk')}}">SK</a></li>
  <li><a style="@if($lang=='en')background-color:#C9D2E0 @endif" href="{{asset('admin/article/en')}}">EN</a></li>
</ul>
    <div class="row">
        <div class="col-md-9">
            <div class="well well-sm">
                <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{asset('admin/article')}}">@csrf
                    <fieldset>

                        <div class="form-group" style="margin-bottom:20px;display:flex">
                            <div class="col-md-4"><label>Dostupnosť:</label>
                                <div style="display:inline-block" class="ui-select">
                                    <select name="audience" id="audience" class="form-control">
                                        <option value="1">Verejné</option selected>
                                        <option value="2">Prihlásený uživateľ</option>
                                    </select>
                                </div>
                            </div>
                            <div style="text-align:right" class="col-md-8">
                                <label>Publikovať:</label>
                                <input style="font-weight: bold;width:150px" type="text" name="dateArticle" id="dateArticle"
                                    value="okamžite" readonly>
                                <a id="showcalendar" href="#">upraviť</a>
                                <div class="hidden" id="choosedate" style="display:none">
                                    <input style="width:100px" type="text" id="datepicker">
                                    <input id="dateconfirm" type="button" style="font-size:0.6rem" class="btn" value="OK">
                                    <a id="hidecalendar" href="#">zrušiť</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="title" name="title" type="text" placeholder="Title" value="" class="form-control title-article">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="perex" name="perex" type="text" placeholder="Perex" value="" class="form-control title-article">
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <div class="col-md-12">
                            OBSAH
                            <textarea name="editor" id="editor"></textarea>
                            <br>
                            <h2>Galéria</h2>
                            Na vytvorenie galérie najprv uložte článok
                            <br>
                        </div>

                        <div class="form-group text-center">
                            <div class="col-md-12">
                                <div class="text-center">
                                    @if($article_photo)
                                    <img src="{{asset($article_photo)}}" class="avatar img-circle" alt="article_photo">
                                    @endif
                                    <br><br>
                                    Titulná fotka:&nbsp<input name="file" id="file" type="file" accept="image/x-png,image/jpeg" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button id="category_save" type="submit" class="btn btn-info show-more">Uložiť</button>
                            </div>
                        </div>
                    </fieldset>
            </div>
        </div>
        <div style="flex-direction: row-reverse" class="col-md-3">
            <div class="card" style="min-height:350px;max-height:400px;overflow-y: scroll;margin:10px 10px">
                <div>
                    <!-- Default panel contents -->
                    <div class="card-header">Kategórie</div>
                    <ul id="category_list" class="list-group list-group-flush">
                        @foreach($categories as $key=>$category)
                        @if($category->id==1)
                        <li class="list-group-item">
                            <label class="switch ">
                                <input onclick="categorycheckboxes(this)" name="category[]" value="{{$category->id}}"
                                    type="checkbox" class="default" checked>
                            </label>
                            &nbsp{{$category->name}}
                        </li>
                        @else
                        <li class="list-group-item">
                            <label class="switch ">
                                <input onclick="categorycheckboxes(this)" name="category[]" value="{{$category->id}}"
                                    type="checkbox" class="default">
                            </label>
                            &nbsp{{$category->name}}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                    <div id="new_cat_add" class="new-article"><i class="fas fa-plus"></i>&nbsp Pridať novú</div>
                    <div id="new_cat_panel" class="hidden" style="display:none">

                        <select id="cat_parent" name="cat_parent" class="form-control">
                            <option value="1" selected>-Nadradená kategória-</option>
                            @foreach($categories as $key=>$category)
                            @if($key!=0)
                            <option name="cat_parent" value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                            @endforeach
                        </select>

                        <input id="new_cat" name="new_cat" placeholder="Kategoria" value="" class="form-control input-tag-category">
                        <button type="button" id="new_cat_save" name="new_cat_save" class="btn input-tag-category ">Uložiť</button>
                    </div>
                </div>
            </div>

            <div class="card" style="min-height:150px;max-height:200px;overflow-y: scroll;margin:10px 10px">
                <!-- Default panel contents -->
                <div class="card-header">Značky</div>
                <input id="new_tag" name="new_tag" placeholder="summer" value="" class="form-control input-tag-category ">
                <div id="for_tags" class="input-tag-category">
                </div>
                <button style="min-height:40px" type="button" id="new_tag_save" name="new_tag_save" class="btn input-tag-category ">Pridať</button>
            </div>
        </div>
    </div>
    </form>
</div>

<script>

$('#holder').on('load', function () {
 $('#image_insert').show();
});

$("#image_insert").click(function(){
    Ajax_add_photo_to_gallery();
});

  


var editor=new Jodit('#editor', {
    enableDragAndDropFileToEditor: true,
    height: 500,
    uploader: {
        url: "{{asset('jodit/upload')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        format: 'json',
        data: {id_article: 'tmp'},
        isSuccess: function (resp) {
            z="{{asset('/')}}"+ resp.files;
            editor.selection.insertImage(z);
        }
    }
});
</script>


<script>

    $(function () {
        $("#datepicker").datepicker();
        $("#ui-datepicker-div").css("z-index", "10");
    });


    $("#showcalendar").click(function () {
        $("#choosedate").show();
        $("#showcalendar").hide();
    });

    $("#hidecalendar").click(function () {
        $("#showcalendar").show();
        $("#choosedate").hide();
    });

    $("#dateconfirm").click(function () {
        if ($("#datepicker").val() != '') {
            $("#dateArticle").val($("#datepicker").val());
            $("#choosedate").hide();
            $("#showcalendar").show();
        }
    });




    var poc = 1;
    var tags = [];
    $("#new_cat_add").click(function () {
        if ($("#new_cat_panel").is(':visible'))
            $("#new_cat_panel").hide();
        else $("#new_cat_panel").show()
    });

    $("#new_tag_save").click(function () {
        if (poc > 10) {
            alert('max 10 tags');
            return;
        }
        value = $('#new_tag').val();
        if (value == '') return;
        $(tags).each(function () {
            if (this == value) {
                zhoda = true;
            }
        });

        $("#for_tags").append("<p value='" + value + "' name='tag" + poc +
            "' onclick='remove(this)'><i class='fas fa-minus-circle'>&nbsp" + value +
            "</i></p>");
        $('<input>').attr({
            type: 'hidden',
            id: 'tag' + poc,
            name: 'tags[]',
            value: $('#new_tag').val()
        }).appendTo('form');
        $('#new_tag').val('');
        poc++;
        tags.push(value);
    });



    function categorycheckboxes($this) {
        // the selector will match all input controls of type :checkbox
        // and attach a click event handler 
        // in the handler, 'this' refers to the box clicked on
        var $box = $($this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }

    }

    function remove($this) {
        $("input[id='" + $($this).closest('p').attr("name") + "']").remove();
        $($this).closest('p').remove();
    }

    $("#new_cat_save").click(function () {
        if ($('#new_cat').val() == "") {
            alert("prazdne pole");
        } else
            Ajax($('#new_cat').val(), $('#cat_parent').val());
    });

    function Ajax(category, parent_cat) {
        $.ajax({
            url: "/savecategory/" + category + '/' + parent_cat,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            success: function (data) {
                if (data == "Kategória s týmto nazvom už existuje") {
                    alert(data);
                    return;
                }
                $("#category_list").append(
                    "<li class='list-group-item'><label class='switch '><input onclick='categorycheckboxes(this)' name='category[]' value='" +
                    data +
                    "' type='checkbox' class='default'></label>&nbsp" + category + "</li>");

                $('<input>').attr({
                    type: 'hidden',
                    name: 'category[]',
                    value: data
                }).appendTo('form');
                $('#new_cat').val('');
            }
        });
    }

</script>
@endsection
