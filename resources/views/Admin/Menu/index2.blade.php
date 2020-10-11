@extends('layout.app_admin')

@section('content')
    <div class="row" style="margin-left:0px; margin-right: 0px;">
        <div class="col-sm-12" style="padding: 20px 20px 0px 20px;">
          <a href="{{asset('/admin/menu?action=edit&menu=0')}}"><div class="new-article btn">Vytvoriť nové menu &nbsp<i class="fas fa-plus"></i></div></a>
            <div style="font-size: 18px; font-weight: 400;color: fff;">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Názov menu</th>
                            <th scope="col">Príznak</th>
                            <th scope="col">Akcie</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($menus as $menu)
                        <tr>
                            <th scope="row">{{$menu->name}}</th>
                            <td>
                            @if($menu->selected_sk)
                                Zvolené pre SK verziu<br />
                            @endif
                            @if($menu->selected_en)
                                Zvolené pre EN verziu
                            @endif
                            </td>
                            <td> 
                                <a href="{{asset("/admin/menu?menu=$menu->id")}}">
                                    <i title="upraviť"
                                    class="fas fa-pencil-alt pen"></i>
                                </a>&nbsp&nbsp&nbsp&nbsp
                                <a href="{{asset("/admin/menu/delete/$menu->id")}}">
                                    <i title="vymazať" class="fas fa-trash bin"></i>
                                </a>&nbsp&nbsp&nbsp&nbsp
                                @if($menu->selected_sk) 
                                    <button class="btn btn-info show-more" style='visibility: hidden'>Nastaviť pre slovenskú verziu</button>
                                @else
                                    <a href="{{asset("/admin/menu/sk/$menu->id")}}"><button class="btn btn-info show-more">Nastaviť pre slovenskú verziu</button></a>
                                @endif
                                @if($menu->selected_en) 
                                    <button class="btn btn-info show-more" style='visibility: hidden'>Nastaviť pre anglickú verziu</button>
                                @else
                                    <a href="{{asset("/admin/menu/en/$menu->id")}}"><button class="btn btn-info show-more">Nastaviť pre anglickú verziu</button></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
