@extends('layout.app_admin')

@section('content')

<head>
    <link href="{{asset('vendor/harimayco-menu/style.css')}}" rel="stylesheet">
</head>
<div class="container">
    <div style=" width: 70%;margin: 0 auto;" class="w3-row">
        {!! Menu::render() !!}
    </div>
</div>

<script>
    var urlRedirect = '{{ asset('/admin/menu/') }}';
</script>

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
$(document).ready(function(){
  $('#menu_sk').change(function(){
    var menu_sk=$('#menu_sk').val();
    var menu_en=$('#menu_en').val();
    var link= "{{asset('admin/menu/Xsk/Xen')}}";
    link= link.replace("Xsk",menu_sk);
    link= link.replace("Xen",menu_en);
    $("#menu_lang_save").attr("href", link);
  });

  $('#menu_en').change(function(){
    var menu_sk=$('#menu_sk').val();
    var menu_en=$('#menu_en').val();
    var link= "{{asset('admin/menu/Xsk/Xen')}}";
    link= link.replace("Xsk",menu_sk);
    link= link.replace("Xen",menu_en);
    $("#menu_lang_save").attr("href", link);
  });
});
</script>

@endsection
