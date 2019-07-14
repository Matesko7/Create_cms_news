<!DOCTYPE <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <link rel="stylesheet" type="text/css" 
    href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" 
    href="{{asset('css/km-consulting.css')}}">
    <link rel="stylesheet" type="text/css" 
    href="{{asset('css/fontawesome-all.css')}}">
    
    <script type="text/javascript" lang="javascript" charset="UTF-8" 
    src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" lang="javascript" charset="UTF-8" 
    src="{{asset('js/popper.min.js')}}"></script>
    <script type="text/javascript" lang="javascript" charset="UTF-8" 
    src="{{asset('js/bootstrap.min.js')}}"></script>
</head>

<body>
    <?php 
        $menu_items = Harimayco\Menu\Facades\Menu::getByName('Default');
    ?>
    @include('inc.navbar_admin', ['menulist' =>$menu_items]) 
    @yield('content')
    @include('inc.footer_admin')
</body>

</html>
