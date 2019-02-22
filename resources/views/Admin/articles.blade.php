@extends('layout.app')

@section('content')
<div class="container">
    <div class="text-center">
        <h2>Články</h2>
    </div>
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
        <div class="new-article btn" >Pridať nový &nbsp<i class="fas fa-plus"></i></div>
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
                            <td>{{$article->user_id}}</td>
                            <td>{{$article->category_id}}</td>
                            <td>{{$article->tags}}</td>
                            <td>{{$article->created_at}}</td>
                            <td>
                                <a href="/admin/article/{{$article->id}}">
                                    <i title="upraviť"
                                        class="fas fa-pencil-alt pen">
                                    </i>
                                </a>&nbsp&nbsp&nbsp&nbsp
                                <a href="/admin/deletearticle/{{$article->id}}">
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
