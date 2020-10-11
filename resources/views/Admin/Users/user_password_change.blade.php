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
            <h2 class="post-heading heading">Zmena hesla</h2>
          </div>
        </div>
      </div>
    </section>
<div class="container">
    <form class="form-horizontal" enctype="multipart/form-data" true method="POST" action="{{asset('/user/changepassword/'.Auth::user()->id)}}">@csrf
        <div style="padding:50px;" class="row">
            <!-- edit form column -->
            <div class="col-md-12 personal-info">
                <h3>Zmena hesla</h3>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Staré heslo:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="oldpassword" name="oldpassword" type="password" value="{{old('oldpassword')}}" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Nové heslo:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="newpassword" name="newpassword" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Potvrdenie nového hesla:</label>
                    <div class="col-lg-8">
                        <input class="form-control" id="newpasswordconfirm" name="newpasswordconfirm" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-info show-more" value="Uložiť zmeny">
                    </div>
                </div>
    </form>
</div>
</div>
</div>
<hr>
<script>
$('#check').click(function(){
    if('password' == $('#oldpassword').attr('type')){
         $('#oldpassword').prop('type', 'text');
    }else{
         $('#oldpassword').prop('type', 'password');
    }
});
</script>
@endsection
