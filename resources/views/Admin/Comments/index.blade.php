@extends('layout.app_admin')

@section('content')

<div class="container">
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Názov článku</th>
                            <th scope="col">počet komentárov</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <th scope="row">{{$article->title}}</th>
                            <td>{{$article->comment_count}}</td>
                            <td style="min-width:80px">
                                <a href="{{asset("admin/comments/article/$article->id")}}">
                                    <i title="upraviť"
                                        class="fas fa-pencil-alt pen">
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
