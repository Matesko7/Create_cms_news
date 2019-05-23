@extends('layout.app_admin')

@section('content')

<div class="container">
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
        <a href="{{asset('admin/article/sk')}}"><div class="new-article btn">Pridať nový &nbsp<i class="fas fa-plus"></i></div></a>
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Názov</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Kategória</th>
                            <th scope="col">Značky</th>
                            <th scope="col">Dátum</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <th scope="row">{{$article->title}}</th>
                            <td>{{$article->user_name}}</td>
                            <td>{{$article->cat_name}}</td>
                            <td >{{$article->tags}}</td>
                            <td style="max-width:150px">{{date("d.m.Y H:i:s",strtotime($article->created_at))}}</td>
                            <td style="min-width:80px">
                                <a href="{{asset("admin/article/sk/$article->id")}}">
                                    <i title="upraviť"
                                        class="fas fa-pencil-alt pen">
                                    </i>
                                </a>&nbsp&nbsp&nbsp&nbsp
                                <a href="{{asset("admin/deletearticle/$article->id")}}">
                                    <i title="vymazať" class="fas fa-trash bin">
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection
