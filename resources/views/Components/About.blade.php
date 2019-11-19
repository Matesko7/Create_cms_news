<section id="about-us">
      <div class="bg">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg text-col">
              <h5 class="about-us-title title">Viac o nás</h5>
              <h2 class="about-us-heading heading">{{$components_content['about'][0]->title}}</h2>
              <img src="{{asset('grafika/grafika/line.png')}}" draggable="false" alt="" class="mb-3 mt-2">
              <p class="about-us-text text">{{$components_content['about'][0]->text}}</p>
              <button type="button" class="btn btn-info show-more">Viac info</button>
            </div>
            <div class="col-lg row image-col justify-content-center align-items-center">
              <img
                src="{{asset($components_content['about'][0]->link)}}"
                alt="obrazok">
              <div class="row align-items-center badge">
                <h6 class="badge-text">5 jázd<br><span class="badge-text-diff">12€</span></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>