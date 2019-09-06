@extends('layout.app')
@section('content')
    @if(count($components))
        @foreach($components as $component)    
            @if($component['component_id'] == 1)
                @include('Components.Carousel')
            @endif  
            @if($component['component_id'] == 2)
                @include('Components.Introduction')
            @endif  
            @if($component['component_id'] == 3)
                @include('Components.About')
            @endif
            @if($component['component_id'] == 4)
                @include('Components.News')
            @endif
            @if($component['component_id'] == 5)
                @include('Components.Top_articles')
            @endif
            @if($component['component_id'] == 6)
                @include('Components.Map')
            @endif
            @if($component['component_id'] == 7)
                @include('Components.Gallery')
            @endif
            @if($component['component_id'] == 8)
                @include('Components.Articles')
            @endif
            @if($component['component_id'] == 9)
                @include('Components.Article')
            @endif
        @endforeach
    @else
        <div class="alert alert-warning text-center m-5" role="alert">
        K tejto stránke nebol pridaný žiadny obsah
        </div>
    @endif
@endsection