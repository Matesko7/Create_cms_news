@extends('layout.app')

@section('content')
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="{{asset('grafika/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('grafika/css/blog-post.css')}}">
</head>

<section id="post-head">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg">
            <nav class="breadcrumb custom-breadcrumb-nav">
              <a href="#" class="breadcrumb-item">
                <h5 class="post-title title">Úvod</h5>
              </a>
              <a href="#" class="breadcrumb-item">
                <h5 class="post-title title">Článok</h5>
              </a>
            </nav>
            <h2 class="post-heading heading">
              @if(App::isLocale('en'))
                    {{$article[0]->title_en}}
                @else
                    {{$article[0]->title}}
                @endif
            </h2>
          </div>
        </div>
      </div>
    </section>

    <section id="post-body">
      <div class="container post-wrap">
        <div class="row">
          <div class="col-lg-8 main-content">
            <div class="main-item">
            @if($article[0]->photo)
              <img src="{{asset($article[0]->photo)}}" alt="cover photo" class="post-body-img">
            @else
                <img src="{{asset('articles/cover.png')}}"  alt="cover article photo" class="post-body-img">
            @endif
              <div class="post">
                <div class="row">
                  <h6 class="post-meta text"><i class="fas fa-pencil-alt"></i> {{$article[0]->user_name}}</h6>
                  <h6 class="post-meta text"><i class="far fa-calendar-alt"></i> {{date("d.m.y",strtotime($article[0]->created_at))}}</h6>
                  <h6 class="post-meta text"><i class="fas fa-comments"></i> {{trans('basics.comments')}}</h6>
                  <h6 class="post-meta text"><i class="fas fa-list"></i><a href="{{asset('/clanky')}}/{{$article[0]->category_id}}/0">
                  @if(App::isLocale('en'))
                    {{$article[0]->cat_name_en}}
                  @else
                    {{$article[0]->cat_name}}
                  @endif 
                  </a></h6>
                </div>
                <h2 class="post-item-heading">@if(App::isLocale('en'))
                    {{$article[0]->title_en}}
                @else
                    {{$article[0]->title}}
                @endif</h2>
                <h5>
                @if(App::isLocale('en'))
                        {{$article[0]->perex_en}}
                    @else
                        {{$article[0]->perex}}
                    @endif
                </h5>
                @if(App::isLocale('en'))
                  <?php echo(nl2br($article[0]->plot_en))?>
                @else
                  <?php echo(nl2br($article[0]->plot))?>
                @endif
                @if($attachments)
                <br><br>
                <h6>Prílohy:</h6>
                @foreach($attachments as $attachment)
                  <a href="{{asset($attachment->link)}}" target="_blank">
                  @if($attachment->attach_name){{$attachment->attach_name}}@else príloha @endif</a><br>
                @endforeach
                @endif
                @if(count($gallery))
                  @include('galeria')
                @endif
              </div>
              
              <div class="row post-tags">
                <div class="col-sm col-lg d-flex flex-row align-items-center tags-row">
                  <h6 class="tags-title">Tags: </h6>
                  @foreach($tags as $tag) 
                    @if($tag != '') 
                  <div class="col-sm col-lg d-flex align-items-center justify-content-center px-1 py-1">
                  <a href="{{asset('/clanky')}}/0/{{$tag}}" class="tag">
                      <h6 class="tag-name text">{{$tag}}</h6>
                    </a>
                  </div>
                    @endif
                  @endforeach
                </div>
                <div class="col-sm col-lg d-flex flex-row justify-content-end social-row">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
              </div>
            </div>
            <div class="main-item">
              <div class="profile">
                <div class="row">
                  <div class="col-lg-4 picture-col">
                    <div class="profile-picture"></div>
                  </div>
                  <div class="col-lg d-flex flex-column justify-content-between desc-col">
                    <h4 class="profile-name">Name</h4>
                    <p class="profile-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro, est!
                      Enim
                      similique sunt obcaecati minima, vero aliquam tempore. Quis accusantium error iure ut libero
                      dolorem voluptates id eum sapiente temporibus.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="main-item">
              <div class="comments">
              @if(Auth::check())
                <div id="user_add_comment" class="comment add-comment">
                  <h2 class="comments-heading heading">Pridať komentár</h2>
                  <form action="{{asset('article/addcoment/'.$article[0]->id)}}" method="post">@csrf
                    <!--<div class="row">
                      <div class="col-md pr-2">
                        <input type="text" name="name" placeholder="{{Auth::user()->name}}" class="add-comment-input" value="" ><br>
                      </div>
                      <div class="col-md pl-2">
                        <input type="email" name="email" placeholder="Email" class="add-comment-input" value="{{Auth::user()->email}}" readonly><br>
                      </div>
                    </div>-->
                    <div class="row">
                      <div class="col-md">
                        <textarea type="text" name="comment" placeholder="Komentár" rows="7"
                          class="add-comment-input"></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md">
                        <input type="submit" value="Odoslať komentár" class="add-comment-submit">
                      </div>
                    </div>
                  </form>
                </div>
                @else
                  <h2 class="comments-heading" style="text-align:center;color:red">Pre vkladanie komentárov sa musíte prihlásiť</h2>
                @endif
                <br><br>
                <h2 class="comments-heading heading">Komentáre: {{count($comments)}}</h2>
                @foreach($comments as $comment)
                <div class="row comment media-query-special">
                  <div class="col-md-12 col-lg-3 media-query-special">
                    <div class="user-picture" style="background-image: url('{{asset('users/'.$comment->user_id.'/'.$comment->user_id.'.jpg')}}');background-postion:center;background-size: cover;background-repeat: no-repeat"></div>
                  </div>
                  <div class="col-md-12 col-lg d-flex flex-row media-query-special">
                    <div class="col-md col-lg-10 d-flex flex-column justify-content-between">
                      <div class="row flex-column justify-content-between">
                        <h6 class="user-name">{{$comment->user_name}}</h4>
                          <h6 class="date">{{date("d.m.Y H:i:s", strtotime($comment->created_at)+3600)}}</h5>
                      </div>
                      <div class="row">
                        <p class="comment-content">{{$comment->comment}}</p>
                      </div>
                      <div class="row" id="reply_to_{{$comment->id}}" style="display: none">
                        <form action="{{asset('article/reply_comment/'.$article[0]->id.'/'.$comment->id)}}" method="post">@csrf
                          <input type="comment" name="comment_reply" placeholder="odpoved na komentár" class="add-comment-input" style="padding:0.5rem">
                          <button  class="reply">Odoslať</button>
                        </form>  
                      </div>
                    </div>
                    <div class="col-md col-lg-2 d-flex flex-row align-items-start normal">
                      <button onclick="comment_reply(this)" value="{{$comment->id}}" class="reply normal">Odpoveď</button>
                    </div>
                  </div>
                  <div class="col-md col-lg-2 d-flex flex-row align-items-start special" id="small-disp">
                    <button onclick="comment_reply(this)" value="{{$comment->id}}" class="reply">Odpoveď</button>
                  </div>
                </div>
                @if($comment->child)
                  @foreach($comment->child as $reply)
                    <div style="margin-left:50px;padding:1rem" class="row comment media-query-special">
                    <div class="col-md-12 col-lg-3 media-query-special">
                      <div class="user-picture" style="background-image: url('{{asset('users/'.$reply['userId'].'/'.$reply['userId'].'.jpg')}}');background-postion:center;background-size: cover;background-repeat: no-repeat"></div>
                    </div>
                    <div class="col-md-12 col-lg d-flex flex-row media-query-special">
                      <div class="col-md col-lg-10 d-flex flex-column justify-content-between">
                        <div class="row flex-column justify-content-between">
                          <h6 class="user-name">{{$reply['userName']}}</h4>
                            <h6 class="date">{{date("d.m.Y H:i:s", strtotime($reply['created_at'])+3600)}}</h5>
                        </div>
                        <div class="row">
                          <p class="comment-content">{{$reply['plot']}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                @endif
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-lg-4 side-content">
            <div class="side-item">
              <div class="search">
                <form action="#">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control search-input" placeholder="Vyhladať" aria-label="Search">
                    <div class="input-group-append">
                      <button class="btn search-submit" type="button"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="categories">
                <h4 class="categories-heading heading">Kategórie</h4>
                <ul>
                @foreach($categories_all as $value)
                <a href="{{asset('/clanky')}}/{{$value->id}}/0"> <li class="category">{{$value->name}}</li></a>  
                @endforeach
                </ul>
              </div>
              <div class="newest-articles">
                <h4 class="newest-articles-heading heading">Posledné články</h4>
                <div class="article">
                  <img src="{{asset('grafika/grafika clanok/baboMama.jpg')}}" class="article-photo mt-0" alt="článok">
                  <div class="row">
                    <h6 class="article-date text"><i class="far fa-calendar-alt"></i> Dátum</h6>
                  </div>
                  <a href="">
                    <h4 class="article-name heading">Názov článku</h4>
                  </a>
                </div>
                <div class="article">
                  <img src="{{asset('grafika/grafika clanok/baboMama.jpg')}}" class="article-photo" alt="článok">
                  <div class="row">
                    <h6 class="article-date text"><i class="far fa-calendar-alt"></i> Dátum</h6>
                  </div>
                  <a href="">
                    <h4 class="article-name heading">Názov článku</h4>
                  </a>
                </div>
              </div>
              <div class="tags">
                <h4 class="tags-heading heading">Tagy</h4>
                <div class="row mb-2">
                @foreach($tags_all as $value)
                <div class="col-sm col-lg d-flex align-items-center justify-content-center px-1 py-1">
                    <a href="{{asset('/clanky')}}/0/{{$value}}" class="tag">
                      <h6 class="tag-name text">{{$value}}</h6>
                    </a>
                </div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<script>
function comment_reply(e){
  $("#reply_to_"+e.value).show();
}
</script>

@endsection
