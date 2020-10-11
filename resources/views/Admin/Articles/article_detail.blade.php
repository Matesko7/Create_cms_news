@extends('layout.app_admin')

@section('content')

<head>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('jodit/build/jodit.min.css')}}">
    <script src="{{asset('jodit/build/jodit.min.js')}}"></script>
</head>
<style>
.flex-container {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  background-color: white;
}

.flex-container > div {
  background-color: #f1f1f1;
  width: 200px;
  margin: 10px;
  text-align: center;
  line-height: 75px;
  font-size: 30px;
}

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
<br>
<ul class="nav nav-tabs">
  <li><a style="@if($lang=='sk')background-color:#C9D2E0 @endif" href="{{asset("admin/article/sk/".$article[0]->id)}}">SK</a></li>
  <li><a style="@if($lang=='en')background-color:#C9D2E0 @endif" href="{{asset("admin/article/en/".$article[0]->id)}}">EN</a></li>
</ul>
    <div class="row">
        <div class="col-md-9">
            <div class="well well-sm">
                <form class="form-horizontal" enctype="multipart/form-data" method="post"
                    action="{{asset("admin/article/".$article[0]->id)}}">
                    @csrf
                    <fieldset>

                        <div class="form-group" style="margin-bottom:20px;display:flex">
                            <div class="col-md-4"><label>Viditeľnosť:</label>
                                <div style="display:inline-block" class="ui-select">
                                    <select name="audience" id="audience" class="form-control">
                                        @if($article[0]->audience==1)
                                        <option value="1">Verejné</option selected>
                                        <option value="2">Prihlásený uživateľ</option>
                                        @else
                                        <option value="1">Verejné</option>
                                        <option value="2" selected>Prihlásený uživateľ</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"><label>Viditeľnosť( Rola):</label>
                                <div style="display:inline-block" class="ui-select">
                                    <select name="audienceRole" id="audienceRole" class="form-control">
                                        <option value="{{null}}" >každý</option>
                                        @foreach($roles as $role)
                                            @if($article[0]->audience_role_id === $role->id)
                                                <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                            @else
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div style="text-align:right" class="col-md-4">
                                <label>Publikovať:</label>
                                <input style="font-weight: bold;width:150px" type="text" name="dateArticle"
                                    
                                    id="dateArticle" value="{{date('d.m.Y',strtotime($article[0]->created_at)+3600)}}"
                                    readonly>
                                <a id="showcalendar" href="#">upraviť</a>
                                <div class="hidden" style="display:none" id="choosedate">
                                    <input style="width:100px" type="text" id="datepicker">
                                    <input id="dateconfirm" type="button" style="font-size:0.6rem" class="btn"
                                        value="OK">
                                    <a id="hidecalendar" href="#">zrušiť</a>
                                </div>
                            </div>
                        </div>
                        <center>Meta tagy
                            <button id="add_metaTag" type="button" class="btn" style="padding: 1px; float: right">Pridať ďalši meta tag<i class="fas fa-plus"></i> </button>
                            <div id="metaTags">
                                <div class="col-md-12 col-sm-12 p-2"><label>&#60; meta name="Description" content=</label>
                                    <div style="display:inline-block" class="ui-select">
                                        <input id="metaTag1" name="metaTag1" type="text" placeholder="About"
                                        value="{{$article[0]->meta_tag_Description}}" class="form-control title-article">
                                    </div>
                                    /&#62;
                                </div>
                                <div class="col-md-12 col-sm-12 p-2"><label>&#60; meta name="Keywords" content=</label>
                                    <div style="display:inline-block" class="ui-select">
                                        <input id="metaTag2" name="metaTag2" type="text" placeholder="Earth"
                                        value="{{$article[0]->meta_tag_Keyword}}" class="form-control title-article">
                                    </div>
                                    /&#62;
                                </div>
                                @if(isset($extra_tags))
                                @foreach($extra_tags as $tag)
                                    <div class='col-md-12 col-sm-12 p-2'>
                                        <label>&#60; meta name=</label>
                                        <div style='display:inline-block' class='ui-select'>
                                            <input id="additionalMetaTagsName[]" name="additionalMetaTagsName[]" type='text' placeholder='og:description' class='form-control title-article' value="{{$tag->name}}">
                                        </div> 
                                        <label> content=</label>
                                        <div style='display:inline-block' class='ui-select'>
                                            <input id='additionalMetaTagsContent[]' name='additionalMetaTagsContent[]' type='text' placeholder='popis' class='form-control title-article' value="{{$tag->value}}">
                                        </div> 
                                        <label>/&#62</label>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </center> 
                        

                        <div class="form-group">
                            <div class="col-md-12">
                                Názov:
                                <input id="title" name="title" type="text" placeholder="Názov článku"
                                    value="@if($lang=='en'){{$article[0]->title_en}}@else{{$article[0]->title}}@endif" class="form-control title-article">
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <div class="col-md-12">
                                Perex:
                                <input id="perex" name="perex" type="text" placeholder="Perex článku"
                                    value="@if($lang=='en'){{$article[0]->perex_en}}@else{{$article[0]->perex}}@endif" class="form-control title-article">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-12">
                                OBSAH
                                <textarea name="editor" id="editor"></textarea>
                                <br>
                                <label for="allowComment">Povoliť komentáre</label>
                                <input type="checkbox" id="allowComment" name="allowComment" value="1" {{  ($article[0]->allowComment == 1 ? ' checked' : '') }}>
                                <br>
                                <!--GALERY ------------------->
                                <h2>Galéria</h2>
                                <div id="1" class="flex-container">
                                @if(count($galery))
                                    @foreach($galery as $img)
                                        <div>
                                            <img src='{{asset($img->link)}}' style='max-height:100px;' alt='obrazok'><br>
                                            <button onclick='Ajax_image_edit(1,{{$img->id}})' type='button' style='margin:5px' class='btn btn-primary'>🡸</button>
                                            <button onclick='Ajax_image_edit(2,{{$img->id}})' type='button' style='margin:5px' class='btn btn-danger'>X</button>
                                            <button onclick='Ajax_image_edit(3,{{$img->id}})' type='button' style='margin:5px' class='btn btn-primary'>🡺</button>
                                        </div>
                                    @endforeach
                                @endif
                                </div>    
                                <br>
                                <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="filepath">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
        <button  id='image_insert' style="display:none" class="btn btn-primary" type="button">Vlož</button>
        <hr><br>
        <!--ATTACHMENTS ------------------->
        <h2>Prílohy<span style="font-size:10px">Maximalna veľkosť prílohy je 50MB</span></h2>
        <div id="attachments" style="margin-bottom:5px;">

            @foreach($attachments as $attachment)
                <div id="attachment_{{$attachment->id}}">
                Príloha: <a href="{{asset($attachment->link)}}" target="_blank">{{$attachment->link}}</a> Názov: {{$attachment->attach_name}}<button type="button" class="btn btn-danger" onclick="deleteAttachment({{$attachment->id}})" style="color:white;padding:2px;"> Vymazať</button><br>
                </div>     
            @endforeach

            @if(!$attachments)
            Príloha: <input type="file" name="attachment[0]" id="attachment[0]" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*">Názov:<input type="text" style="min-width:200px;" name="name_attachment[0]" id="name_attachment[0]"><br><br>
            @endif
            </div>            
            <button id="add_attachment" type="button" class="btn" style="padding: 1px;">Pridať ďalšiu &nbsp<i class="fas fa-plus"></i> </button>
        

        </div>
        <br><hr>
        <!--RELATED ARTICLES ------------------->
        <h2>Príbuzné články</h2>
        <div id="related_articles" style="margin-bottom:5px;">
        <ul id="list_related_articles">
        @foreach($related_articles as $key => $r_article)
            <li id="{{$r_article->id}}">{{$r_article->title}}&nbsp&nbsp<button type="button" class="btn btn-danger" style="color:white;padding:2px;" onclick="deleteRelatedArticle({{$r_article->id}})">Vymazať</button></a></li>
        @endforeach
        </ul>
        Pridať nový<br>
        <div style="width:50%;float:left" >
            <select  name="new_related_article" id="new_related_article" class="form-control" onmousedown="if(this.options.length>6){this.size=6;}"  onchange='this.size=0;' onblur="this.size=0;">
                <option value="0" selected>-Vyberte článok-</option>
                @foreach($articles as $a_article)
                    <option  value="{{$a_article->id}}" >{{substr($a_article->title,0,70)}}</option>                    
                @endforeach
            </select>
        </div>&nbsp&nbsp
        <button class='btn btn-primary' type="button" id="related_article_insert"> vlož</button>    
        </div>  
        <br><br>      
        <br><hr>
        <!--------COVER PHOTO ------------------->
                        <div class="form-group">
                            <div class="col-md-11">
                                <div class="text-center">
                                    @if($article_photo)
                                    <img style="max-width:400px;" src="{{asset($article_photo)}}"
                                        class="avatar img-circle" alt="article_photo">
                                    @endif
                                    <br><br>
                                    Titulná fotka:&nbsp<input name="file" id="file" type="file"
                                        accept="image/x-png,image/jpeg" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-info show-more">Uložiť</button>
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
                        @foreach($categories as $category)
                        @if($category->id==$article_category[0]->category_id)
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

                        <input id="new_cat" name="new_cat" placeholder="Kategoria" value=""
                            class="form-control input-tag-category">
                        <button type="button" id="new_cat_save" name="new_cat_save"
                            class="btn input-tag-category ">Uložiť</button>
                    </div>
                </div>
            </div>


            <div class="card" style="min-height:250px;max-height:300px;overflow-y: scroll;margin:10px 10px">
                <!-- Default panel contents -->
                <div class="card-header">Značky</div>
                <input id="new_tag" name="new_tag" placeholder="summer" value=""
                    class="form-control input-tag-category ">
                <div id="for_tags" class="input-tag-category">
                    @foreach($tags as $key=>$tag)
                    @if($tag!='')
                    <p value="{{$tag}}" name="tag{{$key}}" onclick='remove(this)'><i
                            class='fas fa-minus-circle'>&nbsp{{$tag}}</i></p>
                    @endif
                    @endforeach
                </div>
                <button style="min-height:40px" type="button" id="new_tag_save" name="new_tag_save"
                    class="btn input-tag-category ">Pridať</button>
            </div>
        </div>

    </div>


    @foreach($tags as $key=>$tag)
    {{ Form::hidden('tags[]',$tag,['id'=>'tag'.$key]) }}
    @endforeach
    {{ Form::hidden('user_id',$article[0]->user_id) }}
    {{ Form::hidden('lang',$lang) }}
    {{ Form::hidden('pic_hash', $pic_hash)}}
    </form>


<script>
var new_related_article = true;

var attachment_num={{count($attachments)+1}};
if( attachment_num < 2) attachment_num=2;
$('#add_attachment').click(function(){
    $('#attachments').append("Príloha:  <input type='file' name='attachment["+attachment_num+"]' id='attachment["+attachment_num+"]' accept='application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*'>Názov:<input type='text' style='min-width:200px;' name='name_attachment["+attachment_num+"]' id='name_attachment["+attachment_num+"]'><br><br>");
    attachment_num++;
});

$('#add_related_article').click(function(){
    if(new_related_article){
    $('#related_articles').append("<br>Pridať nový<br><div style='width:50%;float:left'><select class='form-control' onmousedown='if(this.options.length>6){this.size=6;}' onchange='this.size=0;' onblur='this.size=0;'><option value='0' selected>-Vyberte článok-</option>@foreach($articles as $a_article)<option  value='{{$a_article->id}}' >{{substr($a_article->title,0,70)}}</option>@endforeach</select></div>&nbsp&nbsp<button class='btn btn-primary'> vlož</button>");
    new_related_article = false;
    }
    else{
        alert('Riadok na pridanie nového príbuzneho članku už je vytvorený');
    }
});



$('#holder').on('load', function () {
 $('#image_insert').show();
});

$("#image_insert").click(function(){
    Ajax_add_photo_to_gallery();
});

function deleteRelatedArticle(id){
    Ajax_delete_related_article(id);
};
function deleteAttachment(id){
    Ajax_delete_attachment(id);
};



$("#related_article_insert").click(function(){
    var id = $("#new_related_article").val();
    if( id == 0)
        return alert('Nezvolili ste žiadny článok');
    Ajax_add_related_article(id);
});

    var editor = new Jodit('#editor', {
        enableDragAndDropFileToEditor: true,
        height: 500,
        uploader: {
            url: "{{asset('jodit/upload')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            format: 'json',
            data: {'id_article': 'tmp','pic_hash': '{{ $pic_hash }}' },
            isSuccess: function (resp) {
                z = "{{asset('/')}}" + resp.files;
                editor.selection.insertImage(z);
            }
        }
    });

    var z = '';
    if( '{{$lang}}'=='en')
        z = "{{$article[0]->plot_en}}";
    else 
        z = "{{$article[0]->plot}}";

    z = z.replace(/&lt;/g, "<");
    z = z.replace(/&amp;/g, "&");
    z = z.replace(/&gt;/g, ">");
    z = z.replace(/&quot;/g, '"');
    z = z.replace(/&#039;/g, "'");
    editor.value = z;

</script>

<script>
   var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
  </script>

  <script>
    {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
  </script>
  <script>
    $('#lfm').filemanager('image', {prefix: route_prefix});
  </script>

<script>
    $(function () {
        $("#datepicker").datepicker();
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
            var tmp= ($("#datepicker").val()).split("/");
            var date=tmp[1]+"."+tmp[0]+"."+tmp[2];
            $("#dateArticle").val(date);
            $("#choosedate").hide();
            $("#showcalendar").show();
        }
    });

    $("#add_metaTag").click(function () {
        $("#metaTags").append("<div class='col-md-12 col-sm-12 p-2'>&#60; meta name=<div style='display:inline-block' class='ui-select'><input id='additionalMetaTagsName[]' name='additionalMetaTagsName[]' type='text' placeholder='og:description' class='form-control title-article'></div> content= <div style='display:inline-block' class='ui-select'><input id='additionalMetaTagsContent[]' name='additionalMetaTagsContent[]' type='text' placeholder='popis' class='form-control title-article'></div> /&#62</div>")
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


    function Ajax_add_photo_to_gallery() {
        var src=$('#holder').attr('src');
        $.ajax({
            url: '{{asset("/saveImagetoGalery")}}',
            data: {'src': src, 'article_id': {{$article[0]->id}} },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function (id) {
                $("#1").append("<div><img src='"+$('#holder').attr('src')+"' style='max-height:100px;' alt='obrazok'><br><button onclick='Ajax_image_edit(1,"+id+")' type='button' style='margin:5px' class='btn btn-primary'>🡸</button><button onclick='Ajax_image_edit(2,"+id+")' type='button' style='margin:5px' class='btn btn-danger'>X</button><button onclick='Ajax_image_edit(3,"+id+")' type='button' style='margin:5px' class='btn btn-primary'>🡺</button></div>");
            }
        });
    }

    function Ajax_add_related_article(id) {
        $.ajax({
            url: '{{asset("/saveRelatedArticle")}}',
            data: {'related_article': id, 'article_id': {{$article[0]->id}} },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function (article) {
                $("#list_related_articles").append("<li id="+article[0]['id']+">"+article[0]['title']+"&nbsp&nbsp<button type='button' class='btn btn-danger' style='color:white;padding:2px;' onclick='deleteRelatedArticle("+article[0]['id']+")'>Vymazať</button></a></li>");
            }
        });
    }

    function Ajax_delete_related_article(id) {
        $.ajax({
            url: '{{asset("/deleteRelatedArcticle")}}'+"/"+id  ,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            success: function (article) {
                $("#list_related_articles").find("#"+id).remove();
            }
        });
    }

    function Ajax_delete_attachment(id) {
        $.ajax({
            url: '{{asset("/admin/attachment/delete")}}'+"/"+id  ,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            success: function (article) {
                $("#attachment_"+id).remove();
            }
        });
    }
    
    function Ajax_image_edit(action, id){
        $.ajax({
            url: '{{asset("/editGalery")}}',
            data: {'article_id' :  {{$article[0]->id}}, 'action': action, 'image_id' : id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function (data) {
                $("#1").empty();
                data.forEach(element => {
                    $("#1").append("<div><img src='{{asset('/')}}"+element['link']+"' style='max-height:100px;' alt='obrazok'><br><button onclick='Ajax_image_edit(1,"+element['id']+")' type='button' style='margin:5px' class='btn btn-primary'>🡸</button><button onclick='Ajax_image_edit(2,"+element['id']+")' type='button' style='margin:5px' class='btn btn-danger'>X</button><button onclick='Ajax_image_edit(3,"+element['id']+")' type='button' style='margin:5px' class='btn btn-primary'>🡺</button></div>");
                });
            }
        });
    }

</script>
@endsection
