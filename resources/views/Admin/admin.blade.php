@extends('layout.app')

@section('content')
<div class="container">
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
            <h2 style="font-size: 24px; font-weight: 500;text-align: center;">ČLÁNKY</h2>
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
                            <td><a href="/admin/editarticle/{{$article->id}}"><i title="upraviť" class="fas fa-pencil-alt pen"></i></a></td>
                            <td><a href="/admin/deletearticle/{{$article->id}}"><i title="vymazať" class="fas fa-trash bin"></i></a></td>
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
