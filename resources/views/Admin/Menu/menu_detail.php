@extends('layout.app_admin')

@section('content')

<head>
    <link href="{{asset('vendor/harimayco-menu/style.css')}}" rel="stylesheet">
</head>
<div class="container">
    <br><br>
    <div style="display: flex;">
        <label class="col-lg-3 control-label" style="text-align:right">Menu SK:</label>
        <div class="col-lg-3">
            <div class="ui-select">
                <select name="menu_sk" id="menu_sk" class="form-control">
                    <option value="0" selected>--Vybrať menu--</option>
                    @foreach($menus as $menu)
                    @if($menu->selected_sk==1)
                    <option value="{{$menu->id}}" selected>{{$menu->name}}</option>
                    @else
                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <label class="col-lg-3 control-label" style="text-align:right">Menu EN:</label>
        <div class="col-lg-3">
            <div class="ui-select">
                <select name="menu_en" id="menu_en" class="form-control">
                    <option value="0" selected>--Vybrať menu--</option>
                    @foreach($menus as $menu)
                    @if($menu->selected_en==1)
                    <option value="{{$menu->id}}" selected>{{$menu->name}}</option>
                    @else
                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top:15px;">
        <a id="menu_lang_save" href="{{asset('admin/menu')}}"><input type="button" class="btn btn-info"
                value="Uložiť zmeny"></a>
    </div>

    <div style=" width: 70%;margin: 0 auto;" class="w3-row">
        {!! Menu::render() !!}
    </div>
</div>


<script>
    var menus = {
        "oneThemeLocationNoMenus": "",
        "moveUp": "Move up",
        "moveDown": "Mover down",
        "moveToTop": "Move top",
        "moveUnder": "Move under of %s",
        "moveOutFrom": "Out from under  %s",
        "under": "Under %s",
        "outFrom": "Out from %s",
        "menuFocus": "%1$s. Element menu %2$d of %3$d.",
        "subMenuFocus": "%1$s. Menu of subelement %2$d of %3$s."
    };
    var arraydata = [];
    var addcustommenur = '{{ route("haddcustommenu") }}';
    var updateitemr = '{{ route("hupdateitem")}}';
    var generatemenucontrolr = '{{ route("hgeneratemenucontrol") }}';
    var deleteitemmenur = '{{ route("hdeleteitemmenu") }}';
    var deletemenugr = '{{ route("hdeletemenug") }}';
    var createnewmenur = '{{ route("hcreatenewmenu") }}';
    var csrftoken = "{{ csrf_token() }}";
    var menuwr = "{{ url()->current() }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrftoken
        }
    });

</script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/scripts2.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/menu.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#menu_sk').change(function () {
            var menu_sk = $('#menu_sk').val();
            var menu_en = $('#menu_en').val();
            var link = "{{asset('admin/menu/Xsk/Xen')}}";
            link = link.replace("Xsk", menu_sk);
            link = link.replace("Xen", menu_en);
            $("#menu_lang_save").attr("href", link);
        });

        $('#menu_en').change(function () {
            var menu_sk = $('#menu_sk').val();
            var menu_en = $('#menu_en').val();
            var link = "{{asset('admin/menu/Xsk/Xen')}}";
            link = link.replace("Xsk", menu_sk);
            link = link.replace("Xen", menu_en);
            $("#menu_lang_save").attr("href", link);
        });
    });

</script>

@endsection
