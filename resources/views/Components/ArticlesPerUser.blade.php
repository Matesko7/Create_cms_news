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

    .tag-article:hover {
        background-color: #ffae00;
        border-radius: 25px;
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
                <h5 class="post-title title">Použivateľ</h5>
              </a>
            </nav>
            <h2 class="post-heading heading">Použivateľ</h2>
          </div>
        </div>
      </div>
    </section>


    <div class="container">
        <div style="padding:50px;" class="row">
            <!-- left column -->
            <div class="col-md-4">
                <div class="text-center">
                    @if($components_content['articles']['user']->photo)
                        <img style="max-width:100%;" src="{{asset($components_content['articles']['user']->photo)}}" class="avatar img-circle" alt="avatar">
                    @else
                        <img style="max-width:100%;" src="{{asset('users/Unknown_Person.png')}}" class="avatar img-circle" alt="avatar">
                    @endif
                </div>
            </div>
            <!-- edit form column -->
            <div class="col-md-8 personal-info">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Meno:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="name" name="name" type="text" value="{{$components_content['articles']['user']->name}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<center><h1>Články použivateľa</h1></center>
 <div style=" width: 50%;margin: 0 auto;" class="w3-row">           
        <!-- Blog entries -->
        <div style="margssin-left:17%" class="w3-col">
            
        @if($components_content['articles']['articles'])
           @foreach($components_content['articles']['articles'] as $article) 
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
                    <h5>
                    @if(App::isLocale('en'))
                        {{$article->cat_name_en}}
                    @else
                        {{$article->cat_name}}
                    @endif
                    , <span class="w3-opacity">{{date("d.m.y",strtotime($article->created_at))}}</span>
                    <span class="w3-right">Obsah:
                     @if($article->audience==2)
                     <i class="fas fa-lock"></i></span>
                     @else
                     <i class="fas fa-lock-open"></i></span>
                     @endif
                     <span class="tag" style="float:right">
                     @foreach(explode("|", $article->tags) as $tag)
                     @if($tag != "" )
                    <h6 style="display:inline;padding: 5px;" class="tag-name text">#{{$tag}}</h6>
                    &nbsp
                    @endif
                     @endforeach
                     </span>
                    </h5>
                </div>

                <div class="w3-container" style="clear:both">
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
                        <!--<div class="w3-col m4 w3-hide-small">
                            <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-tag">0</span></span></p>
                        </div>-->
                    </div>
                </div>
            </div>
            <hr>
            @endforeach
            @endif
        </div>
    </div>
    @if(empty($components_content['articles']['articles'][0]))
        <center><h4>Použivateľ nemá žiadne články</h4></center> 
    @endif        
    <div class="pagination pagination-centered" style="justify-content: center;">
    @if($components_content['articles']['articles'])
        {{ $components_content['articles']['articles']->links() }}
    @endif
    </div>
    <br>
</div>
