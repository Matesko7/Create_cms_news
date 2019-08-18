@extends('layout.app_admin')

@section('content')
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
        <a href="{{asset('admin/component')}}"><div class="new-article btn">Pridať novú &nbsp<i class="fas fa-plus"></i></div></a>
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Typ komponentu</th>
                            <th scope="col">Názov komponentu</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($components as $component)
                        <tr>
                            <th scope="row">{{$component->type}}</th>
                            <td>{{$component->name}}</td>
                            <td style="min-width:80px">
                                <a href="{{asset('admin/components/edit/'.$component->id)}}">
                                    <i title="upraviť"
                                        class="fas fa-pencil-alt pen">
                                    </i>
                                </a> &nbsp&nbsp&nbsp&nbsp
                                <a href="{{asset('admin/components/delete/'.$component->id)}}">
                                    <i title="vymazať" class="fas fa-trash bin">
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
@endsection
