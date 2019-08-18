@extends('layout.app_admin')

@section('content')

<div class="row" style="margin-left:0px; margin-right: 0px;">
    <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
    <a href="{{asset('admin/category')}}"><div class="new-article btn">Pridať novú &nbsp<i class="fas fa-plus"></i></div></a>
        <div style="font-size: 18px; font-weight: 400;color: fff;">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Názov</th>
                        <th scope="col">Názov EN</th>
                        <th scope="col">Parent kategória</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{$category->name}}</th>
                        <td>{{$category->name_en}}</th>
                        <td>{{$category->parent}}</td>
                        <td style="min-width:80px">
                            <a href="{{asset("admin/category/$category->id")}}">
                                <i title="upraviť"
                                    class="fas fa-pencil-alt pen">
                                </i>
                            </a>&nbsp&nbsp&nbsp&nbsp
                            <a href="{{asset("admin/deletecategory/$category->id")}}">
                                <i title="vymazať" class="fas fa-trash bin">
                                </i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}
    </div>
</div>

@endsection
