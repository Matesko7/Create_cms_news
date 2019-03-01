@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="well well-sm">
                <form class="form-horizontal" method="post" 
                action="{{asset("admin/article/".$article[0]->id)}}">
                @csrf
                    <fieldset>

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

                        <div class="form-group" style="display:flex">
                            <div class="col-md-2"><label>Publikum:</label></div>
                            <div class="col-md-6">
                                <div class="ui-select">
                                    <select name="audience" id="audience" class="form-control">
                                    @if($article[0]->audience==1)
                                        <option value="1" selected>Verejné</option selected>
                                        <option value="2">Prihlásený uživateľ</option>
                                    @else
                                    <option value="1" selected>Verejné</option selected>
                                        <option value="2" selected>Prihlásený uživateľ</option>
                                    @endif    
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control article" id="plot" name="plot" placeholder="Obsah článku"
                                    rows="7">{{$article[0]->plot}}</textarea>
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
        <div class="col-md-3">
            <div class="card" style="min-height:350px;max-height:400px;overflow-y: scroll;margin:10px 10px">
                <div>
                    <!-- Default panel contents -->
                    <div class="card-header">Kategórie</div>
                    <ul id="category_list" class="list-group list-group-flush">
                        @foreach($categories as $category)
                        @if($category->id==$article_category[0]->category_id)
                        <li class="list-group-item">
                            <label class="switch ">
                                <input onclick="categorycheckboxes(this)" name="category[]" value="{{$category->id}}" type="checkbox" class="default" checked>
                            </label>
                            &nbsp{{$category->name}}
                        </li>
                        @else
                        <li class="list-group-item">
                            <label class="switch ">
                                <input onclick="categorycheckboxes(this)" name="category[]" value="{{$category->id}}" type="checkbox" class="default">
                            </label>
                            &nbsp{{$category->name}}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                    <div id="new_cat_add" class="new-article"><i class="fas fa-plus"></i>&nbsp Pridať novú</div>
                    <input id="new_cat" name="new_cat" placeholder="Kategoria" value="" class="form-control input-tag-category hidden">
                    <button type="button" id="new_cat_save" name="new_cat_save" class="btn input-tag-category hidden">Uložiť</button>
                </div>
            </div>
        </div>
    </div>
    <div style="flex-direction: row-reverse" class="row">
        <div class="col-md-3">
            <div class="card" style="min-height:150px;max-height:200px;overflow-y: scroll;margin:10px 10px">
                <!-- Default panel contents -->
                <div class="card-header">Značky</div>
                <input id="new_tag" name="new_tag" placeholder="summer" value="" class="form-control input-tag-category ">
                <div id="for_tags" class="input-tag-category">
                @foreach($tags as $key=>$tag)
                <p value="{{$tag}}" name="tag{{$key}}" onclick='remove(this)'><i class='fas fa-minus-circle'>&nbsp{{$tag}}</i></p>
                @endforeach
                </div>
                <button style="min-height:40px" type="button" id="new_tag_save" name="new_tag_save" class="btn input-tag-category ">Pridať</button>
            </div>
        </div>
@foreach($tags as $key=>$tag)        
    {{ Form::hidden('tags[]',$tag) }}
@endforeach
{{ Form::hidden('user_id',$article[0]->user_id) }}
    </div>
    </form>
</div>


<script>
    $(document).ready(function () {
        var poc = 1;
        $("#new_cat_add").click(function () {
            $("#new_cat").show();
            $("#new_cat_save").show();
        });

        $("#new_tag_save").click(function () {
            if (poc > 10) {
                alert('max 10 tags');
                return;
            }
            value=$('#new_tag').val();
            $("#for_tags").append("<p value='"+value+"' name='tag"+poc+"' onclick='remove(this)'><i class='fas fa-minus-circle'>&nbsp" +value+ "</i></p>");
            $('<input>').attr({
                type: 'hidden',
                name: 'tags[]',
                value: $('#new_tag').val()
            }).appendTo('form');
            $('#new_tag').val('');
            poc++;
        });
    });


    function categorycheckboxes($this){
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
        $($this).closest('p').remove();
        $("input[value='"+$this.getAttribute("value")+"']").remove();
    }

    $("#new_cat_save").click(function () {
        if ($('#new_cat').val() == "") {
            alert("prazdne pole");
        } else
            Ajax($('#new_cat').val());
    });

    function Ajax(category) {
        $.ajax({
            url: "/savecategory/" + category,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            success: function (data) {
                $("#category_list").append(
                    "<li class='list-group-item'><label class='switch '><input onclick='categorycheckboxes(this)' name='category[]' value='" + data +
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
