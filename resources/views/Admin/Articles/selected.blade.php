@extends('layout.app_admin')

@section('content')

<h1>Vybrané články</h1>
{{ Form::open(array('url' => asset("admin/selectedarticles")))}}
<div style="margin:50px;">
@for ($i = 1; $i <= 6; $i++)
    <div>
    <h3>Článok číslo {{ $i }}</h3>
    <b>Názov:</b>
        @if($articles_selected[$i] != '')
            {{$articles_selected[$i]->title}}
        @else
            Žiadny clánok nezvolený
        @endif   
        <br><br>
    <div>
    <div style="margin:auto;width:50%">
        <b>Zvoliť: </b>
        <select name="article_selected_{{$i}}" id="article_selected_{{$i}}" class="form-control">
            <option value="0">------------Žiadny------------</option>
            @foreach($articles as $article)
                @if($articles_selected[$i]['id'] == $article->id)
                <option value="{{$article->id}}" selected>{{$article->title}}</option>
                @else
                <option value="{{$article->id}}">{{$article->title}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <hr>
@endfor
</div>
<div style="text-align: center;">
<button class="btn btn-info show-more">Uložiť</button>
{{ Form::close() }}
</div>
<br>
@endsection 