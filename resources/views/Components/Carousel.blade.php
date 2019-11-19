<section id="reference" style="background-color:black">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin:auto">
    @if(!empty($components_content['carousel']))
        <ol class="carousel-indicators">
        @foreach($components_content['carousel'] as $key => $picture)
            @if($key == 0)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="active"></li>
            @else
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"></li>
            @endif
        @endforeach
        <!-- <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
        </ol>
    @endif
    <div class="carousel-inner">
        @if(!empty($components_content['carousel']))
            @foreach($components_content['carousel'] as $key => $picture)
                @if($key == 0)
                    <div class="carousel-item active" style="max-height: 95vh">
                @else
                    <div class="carousel-item" style="max-height: 95vh">
                @endif
                <img class="d-block" src="{{asset($picture->link)}}" alt="Slide" style="max-height: 95vh; margin:auto">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>ZZ</h5>
                    <p>kk</p>
                </div> -->    
                </div>
            @endforeach
        @endif    
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
</section>