@extends('layout.app')

@section('content')

<head>
    {!! $map['js'] !!}
</head>

<section id="about-us">
      <div class="bg">
        <div class="container">
          <div class="d-flex flex-column align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 248.81 49.99">
              <defs>
                <style>
                  .cls-1 {
                    fill: #fff;
                  }
                </style>
              </defs>
              <title>Asset 3arrow-up</title>
              <g id="Layer_2" data-name="Layer 2">
                <g id="Layer_1-2" data-name="Layer 1">
                  <path class="cls-1"
                    d="M0,50H248.81s-27.9-2.17-53.49-16.42C170.59,19.79,144.55.11,124.49,0h-.17c-20.06.11-46.1,19.79-70.83,33.57C27.9,47.82,0,50,0,50Z" />
                </g>
              </g>
            </svg>
            <a href="#"><img src="grafika/grafika/arrow-down.png" class="arrow-down" alt="Down" draggable="false"></a>
          </div>
          <div class="row justify-content-center">
            <div class="col-lg text-col">
              <h5 class="about-us-title title">Viac o nás</h5>
              <h2 class="about-us-heading heading">Letná prevádzka a prevádzkový predpis</h2>
              <img src="grafika/grafika/line.png" draggable="false" alt="" class="mb-3 mt-2">
              <p class="about-us-text text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nobis alias in
                labore. Excepturi totam beatae praesentium dolorum itaque, neque illo, possimus ut obcaecati officia
                suscipit reiciendis voluptate cum quis unde soluta nulla? In optio, unde, blanditiis pariatur nulla fuga
                corrupti, veritatis officia minima voluptates odio aliquid illum reprehenderit necessitatibus. Velit
                placeat dicta asperiores dolore iure est neque aut doloremque, architecto laborum harum provident
                perspiciatis impedit magni dolorem non. Obcaecati, itaque harum, dignissimos cumque at unde consequatur
                voluptates error excepturi eligendi rem enim tenetur eaque consequuntur dolorum cum voluptate quos
                officiis assumenda veritatis? Pariatur fugiat reiciendis eius dolor veritatis quibusdam id?</p>
              <button type="button" class="btn btn-info show-more">Viac info</button>
            </div>
            <div class="col-lg row image-col justify-content-center align-items-center">
              <img
                src="https://images.newscientist.com/wp-content/uploads/2018/12/18114037/gettyimages-758305393-1-800x533.jpg"
                alt="">
              <div class="row align-items-center badge">
                <h6 class="badge-text">5 jázd<br><span class="badge-text-diff">12€</span></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="benefits">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h5 class="benefits-title title">Benefity</h5>
            <h2 class="benefits-heading heading">Bobovej dráhy</h2>
            <img src="grafika/grafika/line.png" draggable="false" alt="" class="mb-3 mt-2">
          </div>
        </div>
        <div class="row my-4">
          <div class="col-md d-flex align-items-center flex-column">
            <div class="circle orange"><img src="grafika/grafika/ikona-zabava.png" draggable="false" alt=""></div>
            <p class="caption">Zábava</p>
          </div>
          <div class="col-md d-flex align-items-center flex-column">
            <div class="circle pink"><img src="grafika/grafika/ikona-eventy.png" draggable="false" alt=""></div>
            <p class="caption">Eventy</p>
          </div>
          <div class="col-md d-flex align-items-center flex-column">
            <div class="circle light-blue"><img src="grafika/grafika/ikona-pre-rodiny.png" draggable="false" alt=""></div>
            <p class="caption">Pre rodiny</p>
          </div>
          <div class="col-md d-flex align-items-center flex-column">
            <div class="circle green"><img src="grafika/grafika/ikona-detske-tabory.png" draggable="false" alt=""></div>
            <p class="caption">Detské tábory</p>
          </div>
          <div class="col-md d-flex align-items-center flex-column">
            <div class="circle purple"><img src="grafika/grafika/ikona-jednotlivci.png" draggable="false" alt=""></div>
            <p class="caption">Jednotlivci</p>
          </div>
          <div class="col-md d-flex align-items-center flex-column">
            <div class="circle red"><img src="grafika/grafika/ikona-adrenalin.png" draggable="false" alt=""></div>
            <p class="caption">Adrenalín</p>
          </div>
        </div>
      </div>
    </section>

    <section id="subscribe">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-5 d-flex align-items-end flex-column subscribe-head-col">
            <div>
              <h5 class="subscribe-title title">Prihláste sa k nám</h5>
              <h2 class="subscribe-heading heading">Nenechajte si ujsť naše akcie</h2>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-7 d-flex align-items-center flex-column">
            <form action="#" class="row">
              <div class="col-md-12 col-lg pr-1 subscribe-input-col">
                <input type="email" name="email" placeholder="Email" class="search-input"><br>
              </div>
              <div class="col-md-12 col-lg pl-1 subscribe-input-col">
                <input type="submit" value="Prihlásiť" class="search-submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <section id="reference">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h5 class="benefits-title title">Povedali o nás</h5>
            <h2 class="benefits-heading heading">Zážitky z adrenalínu</h2>
            <img src="grafika/grafika/line.png" draggable="false" alt="" class="mb-3 mt-2">
          </div>
        </div>
        <div class="row slider">
          <div class="owl-carousel owl-theme owl-drag">

            <div class="slide-woman d-flex justify-content-center flex-column">
              <p class="slide-text text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero porro ipsam autem asperiores nihil
                suscipit dolore perferendis ullam laborum commodi.
              </p>
              <div class="row profile align-items-end">
                <div class="col d-flex justify-content-end align-self-start">
                  <div class="picture"></div>
                </div>
                <div class="col">
                  <div class="row">
                    <p class="profile-name profile-text text">Name</p>
                  </div>
                  <div class="row">
                    <p class="profile-date profile-text text">Date</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="slide-man d-flex justify-content-center flex-column">
              <p class="slide-text text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero porro ipsam autem asperiores nihil
                suscipit dolore perferendis ullam laborum commodi.
              </p>
              <div class="row profile align-items-end">
                <div class="col d-flex justify-content-end align-self-start">
                  <div class="picture"></div>
                </div>
                <div class="col">
                  <div class="row">
                    <p class="profile-name profile-text text">Name</p>
                  </div>
                  <div class="row">
                    <p class="profile-date profile-text text">Date</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="slide-woman d-flex justify-content-center flex-column">
              <p class="slide-text text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero porro ipsam autem asperiores nihil
                suscipit dolore perferendis ullam laborum commodi.
              </p>
              <div class="row profile align-items-end">
                <div class="col d-flex justify-content-end align-self-start">
                  <div class="picture"></div>
                </div>
                <div class="col">
                  <div class="row">
                    <p class="profile-name profile-text text">Name</p>
                  </div>
                  <div class="row">
                    <p class="profile-date profile-text text">Date</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="slide-man d-flex justify-content-center flex-column">
              <p class="slide-text text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero porro ipsam autem asperiores nihil
                suscipit dolore perferendis ullam laborum commodi.
              </p>
              <div class="row profile align-items-end">
                <div class="col d-flex justify-content-end align-self-start">
                  <div class="picture"></div>
                </div>
                <div class="col">
                  <div class="row">
                    <p class="profile-name profile-text text">Name</p>
                  </div>
                  <div class="row">
                    <p class="profile-date profile-text text">Date</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
    </section>

    <section id="more-info">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg">
            <h5 class="more-info-title title">Pre viac informácií</h5>
            <h2 class="more-info-heading heading">Nás kontaktujte na čísle<br>0915 232 394</h2>
            <button type="button" class="btn btn-info show-more">Viac info</button>
          </div>
        </div>
      </div>
      <br>
        <div class="container text-center content">
            {!! $map['html'] !!}
        </div>
    </section>

    <section id="gallery">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg">
            <h5 class="more-info-title title">Fotografie</h5>
            <h2 class="more-info-heading heading">Z našej galérie</h2>
            <img src="grafika/grafika/line.png" draggable="false" alt="" class="mb-3 mt-2">
          </div>
        </div>
        <div class="row pt-4">
          <div class="col-sm d-flex justify-content-center py-2">
            <a href="grafika/grafika/galeria/1.jpg" data-lightbox="gallery" data-title="Naši spokojní zákazníci">
              <div class="image-thumb image-1"></div>
            </a>
          </div>
          <div class="col-sm d-flex justify-content-center py-2">
            <a href="grafika/grafika/galeria/2.jpg" data-lightbox="gallery" data-title="Naši spokojní zákazníci">
              <div class="image-thumb image-2"></div>
            </a>
          </div>
          <div class="col-sm d-flex justify-content-center py-2">
            <a href="grafika/grafika/galeria/3.jpg" data-lightbox="gallery" data-title="Naši spokojní zákazníci">
              <div class="image-thumb image-3"></div>
            </a>
          </div>
          <div class="col-sm d-flex justify-content-center py-2">
            <a href="grafika/grafika/galeria/4.jpg" data-lightbox="gallery" data-title="Naši spokojní zákazníci">
              <div class="image-thumb image-4"></div>
            </a>
          </div>
          <div class="col-sm d-flex justify-content-center py-2">
            <a href="grafika/grafika/galeria/5.jpg" data-lightbox="gallery" data-title="Naši spokojní zákazníci">
              <div class="image-thumb image-5"></div>
            </a>
          </div>
        </div>
      </div>
    </section>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    setTimeout(function () {
        google.maps.event.trigger(markers_map[0], 'click');
    }, 2000);

</script>
@endsection
