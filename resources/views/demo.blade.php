@extends('layout.app')

@section('content')
<div class="row">
  <div class="col-md-12">

    <div id="mdb-lightbox-ui"></div>

    <div class="mdb-lightbox">

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(145).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(145).jpg" class="img-fluid">
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(150).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(150).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(152).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(152).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(42).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(42).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(151).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(151).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(40).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(40).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(148).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(148).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(147).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(147).jpg" class="img-fluid" />
        </a>
      </figure>

      <figure class="col-md-4">
        <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(149).jpg" data-size="1600x1067">
          <img alt="picture" src="https://mdbootstrap.com/img/Photos/Lightbox/Thumbnail/img%20(149).jpg" class="img-fluid" />
        </a>
      </figure>

    </div>

  </div>
</div>

<script>
// MDB Lightbox Init
$(function () {
$("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
});
</script>

@endsection