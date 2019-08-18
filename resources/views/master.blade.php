<?php
    // echo($components_content['map']['html']);
    // exit;
?>
@extends('layout.app')
@section('content')
    @if($components)
        @foreach($components as $component)    
            @if($component['component_id'] == 1)
                @include('components.Carousel')
            @endif  
            @if($component['component_id'] == 2)
                @include('components.Introduction')
            @endif  
            @if($component['component_id'] == 3)
                @include('components.About')
            @endif
            @if($component['component_id'] == 4)
                @include('components.News')
            @endif
            @if($component['component_id'] == 5)
                @include('components.Top_articles')
            @endif
            @if($component['component_id'] == 6)
                @include('components.Map')
            @endif
            @if($component['component_id'] == 7)
                @include('components.Gallery')
            @endif
            @if($component['component_id'] == 8)
                @include('components.Articles')
            @endif
            @if($component['component_id'] == 9)
                @include('components.Article')
            @endif
        @endforeach
    @else
        <div class="alert alert-warning text-center m-5" role="alert">
        K tejto stránke nebol pridaný žiadny obsah
        </div>
    @endif
@endsection