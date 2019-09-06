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
              <h2 class="about-us-heading heading">{{$components_content['about'][0]->title}}</h2>
              <img src="grafika/grafika/line.png" draggable="false" alt="" class="mb-3 mt-2">
              <p class="about-us-text text">{{$components_content['about'][0]->text}}</p>
              <button type="button" class="btn btn-info show-more">Viac info</button>
            </div>
            <div class="col-lg row image-col justify-content-center align-items-center">
              <img
                src="{{$components_content['about'][0]->link}}"
                alt="obrazok">
              <div class="row align-items-center badge">
                <h6 class="badge-text">5 jázd<br><span class="badge-text-diff">12€</span></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>