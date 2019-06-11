@extends('layout.app_admin')

@section('content')

<div class="container">
<h3 style="text-align:center">KOMENTÁRE</h3><hr style="border-top: 1px solid red;">
@foreach($comments as $comment)
<div style="margin-left:50px;padding:1rem" class="row comment media-query-special">
    <div class="col-md-12 col-lg d-flex flex-row media-query-special">
        <div class="col-md col-lg-10 d-flex flex-column justify-content-between">
            <div class="row flex-column justify-content-between">
                <h6 class="user-name"><b>MENO:</b> Matej</h4>
                <h6 class="date"><b>DATUM:</b> {{date("d.m.Y H:i:s", strtotime($comment->created_at)+3600)}}</h5>
            </div>
            <div class="row">
                <p class="comment-content"><b>OBSAH:</b> {{$comment->comment}}</p>
            </div>
        </div>
    </div>
</div>
    <div style="text-align: center">
        @if($comment->is_approved)
        <a href="{{asset('admin/comment/deny/'.$comment->id)}}"><button class="btn-danger">Zmazať</button></a>
        @else
        <a href="{{asset('admin/comment/approve/'.$comment->id)}}"><button class="btn-success">Aktivovať</button></a>
        @endif
    </div>
<hr>
@endforeach
{{ $comments->links() }}
<br>
</div>
@endsection