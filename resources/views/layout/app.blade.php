<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- CSS -->
  <link rel="stylesheet" href="{{asset('grafika/css/style.css')}}">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('grafika/css/bootstrap.min.css')}}">
  <!-- Font Awsome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="{{asset('grafika/owlcarousel/assets/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('grafika/owlcarousel/assets/owl.theme.default.min.css')}}">
  <!-- Lightbox CSS -->
  <link href="{{asset('grafika/lightbox/css/lightbox.css')}}" rel="stylesheet">
  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700,900|Schoolbell&amp;subset=latin-ext"
    rel="stylesheet">

    <!-- JS -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS, then Owl Carousal, then Lightbox -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
  </script>
  <script type="text/javascript" lang="javascript" charset="UTF-8" 
    src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>
  <script type="text/javascript" lang="javascript" charset="UTF-8" 
    src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('grafika/lightbox/js/lightbox.js')}}"></script>
  <script src="{{asset('grafika/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('grafika/js/carousel.js')}}"></script>
  <script src="{{asset('grafika/js/scroll.js')}}"></script>

  @if(isset($article[0]->title))
    <title>@if(App::isLocale('en')){{$article[0]->title_en}}@else{{$article[0]->title}}@endif</title>
    <meta name="description" content="@if(App::isLocale('en')){{$article[0]->perex_en}}@else{{$article[0]->perex}}@endif">
    <meta name="og:title" property="og:title" content="@if(App::isLocale('en')){{$article[0]->title_en}}@else{{$article[0]->title}}@endif">
    <meta property="og:title" content="@if(App::isLocale('en'))
                    {{$article[0]->title_en}}
                @else
                    {{$article[0]->title}}
                @endif" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="{{Request::url()}}" />
  @if($article[0]->photo)
    <meta property="og:image" content="{{asset($article[0]->photo)}}" />
  @endif
  @else
    <title>Bobová dráha</title>
  @endif
</head>
<?php 
      if(App::isLocale('sk'))
        $tmp = DB::select("select name from admin_menus where selected_sk=1")[0]->name;
      else
        $tmp = DB::select("select name from admin_menus where selected_en=1")[0]->name;

        if($tmp)
          $menu_items = Harimayco\Menu\Facades\Menu::getByName($tmp);
        else
          $menu_items = Harimayco\Menu\Facades\Menu::getByName("Default");
?>

<body>
    @include('inc.navbar', ['menulist' =>$menu_items]) 
  <main>
  @include('inc.messages')
  @yield('content')
  @include('inc.footer')
  </main>
</body>

</html>