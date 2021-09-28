@extends('layout.app_admin')

@section('content')

<div class="row" style="margin-left:0px; margin-right: 0px;">
    <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
    <a href="{{asset('admin/option')}}"><div class="new-article btn">Pridať nové nastavenie &nbsp<i class="fas fa-plus"></i></div></a>
    <a href="{{asset('clear-cache')}}" style="float:right"><button  class="btn btn-primary show-more">Vymazať cache</button></a>
        <div style="font-size: 18px; font-weight: 400;color: fff;">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">č.</th>
                        <th scope="col">Typ</th>
                        <th scope="col">Hodnota</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($options as $key => $option)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{{$option->name}}</th>
                        @if($option->type_id == 4)
                            <td> &#60; meta {{ explode("||", $option->value)[0]}}="{{ explode("||", $option->value)[1]}}" content="{{ explode("||", $option->value)[2]}}" /&#62; </td>
                        @elseif($option->type_id == 8)
                            <td> &#60; link {{ explode("||", $option->value)[0]}}="{{ explode("||", $option->value)[1]}}" href="{{ explode("||", $option->value)[2]}}" /&#62; </td>
                        @elseif($option->type_id == 6)    
                            <td>email: {{ explode("||", $option->value)[0]}}, alias: {{ explode("||", $option->value)[1]}}</td>
                        @elseif($option->type_id == 9)    
                            <td>{{$option->value == 1 ? 'Header - Center - Footer' : ($option->value == 2 ? 'Header - Center(L-M-R) - Footer' : 'Header - Center(L-R) - Footer') }}</td>
                        @else
                            <td>{{$option->value}}</td>
                        @endif
                        <td style="min-width:80px">
                            <a href="{{asset("admin/option/$option->id")}}">
                                <i title="upraviť"
                                    class="fas fa-pencil-alt pen">
                                </i>
                            </a>&nbsp&nbsp&nbsp&nbsp
                            <a href="{{asset("admin/deleteoption/$option->id")}}">
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
