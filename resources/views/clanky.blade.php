@extends('layout.app')

@section('content')

<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
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

<div class="container">
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
                    <h3><b>{{$article->title}}</b></h3>
                    <h5>{{$article->cat_name}}, <span class="w3-opacity">{{date("d.m.y",strtotime($article->created_at))}}</span>
                    <span class="w3-right">Obsah:
                     @if($article->audience==2)
                     <i class="fas fa-lock"></i></span>
                     @else
                     <i class="fas fa-lock-open"></i>
                     @endif
                    </h5>
                </div>

                <div class="w3-container">
                    <p style="text-align:justify">{{$article->perex}}</p>
                    <div class="w3-row">
                        <div class="w3-col m8 s12">
                            <p><a href="{{asset("clanok/$article->id")}}"><button class="w3-button w3-padding-large w3-white w3-border"><b>Celý článok »</b></button></a></p>
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

@endsection
