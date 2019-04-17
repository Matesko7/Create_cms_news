@extends('layout.app')

@section('content')

<head>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="container">
<br>
    <div class="row">
        <div class="col-md-9">
            <div class="well well-sm">
                <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{asset("admin/article/".$article[0]->id)}}">
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
                            <div style="text-align:right" class="col-md-8">
                                <label>Publikovať:</label>
                                <input style="font-weight: bold;width:100px" type="text" name="dateArticle" id="dateArticle"
                                    value="{{date('m/d/Y',strtotime($article[0]->created_at)+3600)}}" readonly>
                                <a id="showcalendar" href="#">upraviť</a>
                                <div class="hidden" id="choosedate">
                                    <input style="width:100px" type="text" id="datepicker">
                                    <input id="dateconfirm" type="button" style="font-size:0.6rem" class="btn" value="OK">
                                    <a id="hidecalendar" href="#">zrušiť</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="title" name="title" type="text" placeholder="Title" value="{{$article[0]->title}}"
                                    class="form-control title-article">
                            </div>
                        </div>
                        <br><br>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="perex" name="perex" type="text" placeholder="Perex" value="{{$article[0]->perex}}"
                                    class="form-control title-article">
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-12">
                            OBSAH
                                <textarea name="ce" id="ce" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-11">
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
                                <button id="category_save" type="submit" class="btn  btn-lg">Uložiť</button>
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

                    <div id="new_cat_panel" class="hidden">

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


            <div class="card" style="min-height:250px;max-height:300px;overflow-y: scroll;margin:10px 10px">
                <!-- Default panel contents -->
                <div class="card-header">Značky</div>
                <input id="new_tag" name="new_tag" placeholder="summer" value="" class="form-control input-tag-category ">
                <div id="for_tags" class="input-tag-category">
                    @foreach($tags as $key=>$tag)
                    @if($tag!='')
                    <p value="{{$tag}}" name="tag{{$key}}" onclick='remove(this)'><i class='fas fa-minus-circle'>&nbsp{{$tag}}</i></p>
                    @endif
                    @endforeach
                </div>
                <button style="min-height:40px" type="button" id="new_tag_save" name="new_tag_save" class="btn input-tag-category ">Pridať</button>
            </div>
        </div>

    </div>


    @foreach($tags as $key=>$tag)
    {{ Form::hidden('tags[]',$tag,['id'=>'tag'.$key]) }}
    @endforeach
    {{ Form::hidden('user_id',$article[0]->user_id) }}
    </form>
</div>


<script>
   var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
  </script>

  <!-- CKEditor init -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
  <script>
    $('textarea[name=ce]').ckeditor({
      height: 600,
      filebrowserImageBrowseUrl: route_prefix + '?type=Images',
      filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
      filebrowserBrowseUrl: route_prefix + '?type=Files',
      filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'
    });
    
    var z="{{$article[0]->plot}}";
   
    z = z.replace(/&lt;/g, "<");
    z = z.replace(/&amp;/g, "&");
    z = z.replace(/&gt;/g, ">");
    z = z.replace(/&quot;/g, '"');
    z = z.replace(/&#039;/g, "'");
    $('textarea[name=ce]').val(z);
  </script>

  

  <script>
    {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
  </script>
  <script>
    $('#lfm').filemanager('image', {prefix: route_prefix});
    $('#lfm2').filemanager('file', {prefix: route_prefix});
  </script>

  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
  <script>
    $(document).ready(function() {
      $('#summernote').summernote();
    });
  </script>
  <script>
    $(document).ready(function(){

      // Define function to open filemanager window
      var lfm = function(options, cb) {
          var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
          window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
          window.SetUrl = cb;
      };

      // Define LFM summernote button
      var LFMButton = function(context) {
          var ui = $.summernote.ui;
          var button = ui.button({
              contents: '<i class="note-icon-picture"></i> ',
              tooltip: 'Insert image with filemanager',
              click: function() {

                  lfm({type: 'image', prefix: '/laravel-filemanager'}, function(url, path) {
                      context.invoke('insertImage', url);
                  });

              }
          });
          return button.render();
      };

      // Initialize summernote with LFM button in the popover button group
      // Please note that you can add this button to any other button group you'd like
      $('#summernote-editor').summernote({
          toolbar: [
              ['popovers', ['lfm']],
          ],
          buttons: {
              lfm: LFMButton
          }
      })
    });
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
