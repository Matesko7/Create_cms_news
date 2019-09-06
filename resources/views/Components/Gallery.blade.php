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
        @if(!empty($components_content['gallery']))
          @foreach($components_content['gallery'] as $picture)
          <div class="col-sm d-flex justify-content-center py-2">
            <a href="{{asset($picture->link)}}" data-lightbox="gallery" data-title="Naši spokojní zákazníci">
              <div class="image-thumb" style="background-image: url('{{asset($picture->link)}}')"></div>
            </a>
          </div>
          @endforeach
        @endif
        </div>
      </div>
    </section>