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
    <div style=" width: 70%;margin: 0 auto;" class="w3-row">

        <!-- Blog entries -->
        <div class="w3-col">

            <!-- Blog entry -->
            <div class="w3-card-12 w3-margin w3-white">
                @if($article[0]->photo)
                <img src="{{asset($article[0]->photo)}}" alt="Cover photo" style="width:100%">
                @else
                <img src="{{asset('articles/cover.png')}}" alt="Cover photo" style="width:100%">
                @endif
                <div class="w3-container">
                    <h3 class="text-center"><b>{{$article[0]->title}}</b></h3>
                    <h5>{{$article[0]->cat_name}}, <span class="w3-opacity">{{date("d.m.y",strtotime($article[0]->created_at))}}</span>
                    <span class="w3-right"><b>Autor:</b> {{$article[0]->user_name}}</span>
                    </h5>
                </div>

                <div class="w3-container">
                    <h4>{{$article[0]->perex}}</h4>
                    <div class="w3-row">
                        <div class="w3-col m12 s12">
                            <?php echo(nl2br($article[0]->plot))?>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-col m12 w3-hide-small">
                            
                            <p><span class="w3-padding-large w3-left"> 
                            @foreach($tags as $tag)
                            <span class="w3-tag">#{{$tag}}</span>
                            @endforeach
                            </span></p>
                            
                            <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-tag">0</span></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <br>
</div>

@endsection
