@extends('layout.app')

@section('content')
<div class="container content">
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="background-color: #0076ae; padding: 20px 0 0 20px;">
            <h2 style="font-size: 24px; font-weight: 500;color: fff;text-align: center;">ČLÁNKY</h2>
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                @foreach($articles as $article)
                <p>{{$article->title}}</p>
                @endforeach
            </div>
            {{ $articles->links() }}
        </div>
    </div>
</div>

@endsection
