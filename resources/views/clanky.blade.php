@extends('layout.app')

@section('content')

<head>

  <link rel="stylesheet" href="{{asset('grafika/css/blog-post.css')}}">
</head>
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5 {
        font-family: "Raleway", sans-serif
    }

</style>

<section id="post-head">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg">
            <nav class="breadcrumb custom-breadcrumb-nav">
              <a href="#" class="breadcrumb-item">
                <h5 class="post-title title">Úvod</h5>
              </a>
              <a href="#" class="breadcrumb-item">
                <h5 class="post-title title">Články</h5>
              </a>
            </nav>
            <h2 class="post-heading heading">{{trans('basics.articles')}}</h2>
          </div>
        </div>
      </div>
    </section>

<div class="container">
<div style="display:flex;padding-top:15px;" class="form-group">    
                <div style="margin:auto;text-align:right!important" class="col-md-5 col-sm-12 text-center">
                    <span>{{trans('basics.cat_filter')}}</span>
                    <select  onchange="categorychange()" id="category" name="category" type="text" style="width:60%;display:inline" class="form-control">
                        <option value='0' >--Kategória--</option>
                        @foreach($categories as $value)
                            @if($value->id == $category)
                                <option value={{$value->id}} selected>{{$value->name}}</option>
                            @else
                                <option value={{$value->id}}>{{$value->name}}</option>
                            @endif
                        @endforeach
                    </select>    
                </div>

                <div style="margin:auto;text-align:right!important" class="col-md-5 text-center">
                    <span>{{trans('basics.tag_filter')}}</span>
                    <select  onchange="tagchange()" id="tag" name="tag" type="text" placeholder="Porsche" style="width:60%;display:inline" class="form-control">
                        <option value='0' >--Tag--</option>
                        @foreach($tags as $value)
                            @if($value == $tag)
                                <option value='{{$value}}' selected>{{$value}}</option>
                            @else
                                <option value='{{$value}}'>{{$value}}</option>
                            @endif
                        @endforeach
                    </select>    
                </div>
    </div>     
    <!-- Grid -->
    <div style=" width: 50%;margin: 0 auto;" class="w3-row">           
        <!-- Blog entries -->
        <div style="margssin-left:17%" class="w3-col">
            
           @foreach($articles as $article) 
            <!-- Blog entry -->
            <div class="w3-card-12 w3-margin w3-white">
                @if($article->photo)
                    <img src="{{asset("$article->photo")}}"
                    alt="Cover photo" style="width:100%">
                @else
                    <img src="{{asset('articles/cover.png')}}"
                    alt="Cover photo" style="width:100%">
                @endif
                <div class="w3-container">
                    <h3><b>
                @if(App::isLocale('en'))
                    {{$article->title_en}}
                @else
                    {{$article->title}}
                @endif
                    </b></h3>
                    <h5><a href="{{asset('/clanky')}}/{{$article->category_id}}/0">
                    @if(App::isLocale('en'))
                        {{$article->cat_name_en}}
                    @else
                        {{$article->cat_name}}
                    @endif
                    </a>, <span class="w3-opacity">{{date("d.m.y",strtotime($article->created_at))}}</span>
                    <span class="w3-right">Obsah:
                     @if($article->audience==2)
                     <i class="fas fa-lock"></i></span>
                     @else
                     <i class="fas fa-lock-open"></i>
                     @endif
                    </h5>
                </div>

                <div class="w3-container">
                    <p style="text-align:justify">                
                    @if(App::isLocale('en'))
                        {{$article->perex_en}}
                    @else
                        {{$article->perex}}
                    @endif
                    </p>
                    <div class="w3-row">
                        <div class="w3-col m8 s12">
                            <p><a href="{{asset("clanok/$article->id")}}"><button class="w3-button w3-padding-large w3-white w3-border"><b>{{trans('basics.full_article')}} »</b></button></a></p>
                        </div>
                        <div class="w3-col m4 w3-hide-small">
                            <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-tag">0</span></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
          @endforeach
        </div>
    </div>
    {{ $articles->links() }}
    <br>
</div>

<script>
function categorychange(){
    var url=''
    var z='{{$tag}}';
    if(z !=""){
       url="{{asset('/clanky')}}"+"/"+$("#category").val()+"/"+z;
    }
    else{ 
        url="{{asset('/clanky')}}"+"/"+$("#category").val()+"/0";
    }
    window.location= url;
}

function tagchange(){
    var url=''
    var z='{{$category}}';
    if(z !=""){
       url="{{asset('/clanky')}}"+"/"+z+"/"+$("#tag").val();
    }
    else{ 
        url="{{asset('/clanky')}}"+"/0/"+$("#tag").val();
    }
    window.location= url;
}
</script>


@endsection
