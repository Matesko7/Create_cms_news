<!DOCTYPE <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KM Uctovníctvo</title>
	<link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.png')}}"/>
    
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
    @include('inc.navbar') 
    @yield('content')
    @include('inc.footer')
</body>

</html>
