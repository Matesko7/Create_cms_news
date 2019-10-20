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

</style>

<div class="m-5">
    <!--GALERY ------------------->
    <h2>Carousel</h2>
    <div id="1" class="flex-container">
    @if(count($carousel))
        @foreach($carousel as $img)
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
        </div>


  <script>
    $('#holder').on('load', function () {
        $('#image_insert').show();
    });

    $("#image_insert").click(function(){
      Ajax_add_photo_to_gallery();
    });

    function Ajax_add_photo_to_gallery() {
        var src=$('#holder').attr('src');
        $.ajax({
            url: '{{asset("/saveImagetoComponentCarousel")}}',
            data: {'src': src, 'component_id': {{$component[0]->id}} },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function (id) {
                $("#1").append("<div><img src='"+$('#holder').attr('src')+"' style='max-height:100px;' alt='obrazok'><br><button onclick='Ajax_image_edit(1,"+id+")' type='button' style='margin:5px' class='btn btn-primary'>🡸</button><button onclick='Ajax_image_edit(2,"+id+")' type='button' style='margin:5px' class='btn btn-danger'>X</button><button onclick='Ajax_image_edit(3,"+id+")' type='button' style='margin:5px' class='btn btn-primary'>🡺</button></div>");
            }
        });
    }

    function Ajax_image_edit(action, id){
        $.ajax({
            url: '{{asset("/editComponentCarousel")}}',
            data: {'id' :  {{$component[0]->id}}, 'action': action, 'image_id' : id },
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

  <script>
    var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
  </script>

  <script>
    {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
  </script>
  
  <script>
    $('#lfm').filemanager('image', {prefix: route_prefix});
  </script>


@endsection