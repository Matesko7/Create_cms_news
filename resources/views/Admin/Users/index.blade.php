@extends('layout.app')

@section('content')
<head>
	<link rel="stylesheet" href="{{asset('grafika/css/blog-post.css')}}">
</head>

<section id="post-head">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg">
            <nav class="breadcrumb custom-breadcrumb-nav">
              <a href="#" class="breadcrumb-item">
                <h5 class="post-title title">Profil</h5>
              </a>
              <a href="#" class="breadcrumb-item">
                <h5 class="post-title title">Edit</h5>
              </a>
            </nav>
            <h2 class="post-heading heading">Editácia profilu</h2>
          </div>
        </div>
      </div>
    </section>
<div class="container">
    <form class="form-horizontal" enctype="multipart/form-data" true method="POST" action="{{asset('/user/'.Auth::user()->id)}}">@csrf
        <div style="padding:50px;" class="row">
            <!-- left column -->
            <div class="col-md-4">
                <div class="text-center">
                    @if($user_photo)
                    <img style="max-width:100%;" src="{{asset($user_photo)}}" class="avatar img-circle" alt="avatar">
                    @else
                    <img style="max-width:100%;" src="{{asset('users/Unknown_Person.png')}}" class="avatar img-circle" alt="avatar">
                    @endif
                    <br><br>
                    <input name="file" id="file" type="file" accept="image/x-png,image/jpeg" />
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-8 personal-info">
                <h3>Osobné informácie</h3>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Meno:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="name" name="name" type="text" value="{{Auth::user()->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="email" name="email" type="text" value="{{Auth::user()->email}}"
                            readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-info show-more" value="Uložiť zmeny">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Zruš">
                    </div>
                </div>
    </form>
</div>
</div>
</div>
<hr>
@endsection
