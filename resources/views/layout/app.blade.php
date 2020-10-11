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

  <?php
        $title="";
        $desc_tag="";
        $keyw_tag="";
        $tmp = DB::select("select value from general_options where type_id=5");
        if($tmp)
          $title=$tmp[0]->value;
        $meta_tags = DB::select("select value from general_options where type_id=4");
        foreach($meta_tags as $meta_tag){
          if( strtoupper(explode("||", $meta_tag->value)[1]) != "DESCRIPTION" && strtoupper(explode("||", $meta_tag->value)[1]) != "KEYWORDS" )
            echo( "<meta ".explode("||", $meta_tag->value)[0]."='".explode("||", $meta_tag->value)[1]."' content='".explode("||", $meta_tag->value)[2]."' />");
          else{
            if( strtoupper(explode("||", $meta_tag->value)[1]) == "DESCRIPTION" )
              $desc_tag= "<meta ".explode("||", $meta_tag->value)[0]."='".explode("||", $meta_tag->value)[1]."' content='".explode("||", $meta_tag->value)[2]."' />";
            if( strtoupper(explode("||", $meta_tag->value)[1]) == "KEYWORDS" )
              $keyw_tag= "<meta ".explode("||", $meta_tag->value)[0]."='".explode("||", $meta_tag->value)[1]."' content='".explode("||", $meta_tag->value)[2]."' />";  
          }
        }
        
        $link_tags = DB::select("select value from general_options where type_id=8");
        foreach($link_tags as $link_tag){
            echo( "<link ".explode("||", $link_tag->value)[0]."='".explode("||", $link_tag->value)[1]."' href='".explode("||", $link_tag->value)[2]."' />");
        }
        
  ?>

  @if( strpos(Route::current()->getName(),'article_single') !== false)
    <title>{{$title}} - @if(App::isLocale('en')){{$components_content['article']['article'][0]->title_en}}@else{{$components_content['article']['article'][0]->title}}@endif</title>
    @if($components_content['article']['article'][0]->meta_tag_Description)
      <meta  name="Description" content="{{$components_content['article']['article'][0]->meta_tag_Description}}" />
    @endif  
    @if($components_content['article']['article'][0]->meta_tag_Keyword)
      <meta  name="Keywords" content="{{$components_content['article']['article'][0]->meta_tag_Keyword}}" />
    @endif
    @foreach($components_content['article']['extra_tags'] as $tag)
        <meta  name="{{$tag->name}}" content="{{$tag->value}}" />
    @endforeach
  @else
    <title>{{$title}}</title>
    {!! $desc_tag !!}
    {!! $keyw_tag !!}
  @endif
</head>
<?php 
      $tmp=false;
      if(App::isLocale('sk')){
        if(DB::select("select name from admin_menus where selected_sk=1"))
          $tmp = DB::select("select name from admin_menus where selected_sk=1")[0]->name;
      } 
      else{
        if(DB::select("select name from admin_menus where selected_en=1"))
          $tmp = DB::select("select name from admin_menus where selected_en=1")[0]->name;
      }

      $menu_items = []; 
      if($tmp)
        $menu_items = Harimayco\Menu\Facades\Menu::getByName($tmp);
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