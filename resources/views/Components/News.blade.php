<section id="reference" style="background-color:ghostwhite">
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <h5 class="benefits-title title">Aktuálne</h5>
            <h2 class="benefits-heading heading">Novinky</h2>
            <img src="grafika/grafika/line.png" draggable="false" alt="" class="mb-3 mt-2">
          </div>
        </div>
        <div class="row slider">
          <div class="owl-carousel owl-theme owl-drag">

          @foreach($components_content['news'] as $new)        
            <div class="slide-woman d-flex justify-content-center flex-column">
              <p class="slide-text text" style="height:100%">
                <a href="{{asset('clanok/'.$new->id)}}">{{$new->title}}</a>
              </p>
              <div class="row profile align-items-end">
                <div class="col d-flex justify-content-end align-self-start">
                  <div class="picture"></div>
                </div>
                <div class="col">
                  <div class="row">
                    <p class="profile-name profile-text text">{{$new->author}}</p>
                  </div>
                  <div class="row">
                    <p class="profile-date profile-text text">{{date("d.m.Y H:i:s", strtotime($new->created_at)+3600)}}</p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach        
          </div>
        </div>
    </section>