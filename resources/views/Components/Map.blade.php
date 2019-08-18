<head>
    {!! $components_content['map']['js'] !!}
</head>

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
        {!! $components_content['map']['html'] !!}
    </div>
</section>

<script>
    setTimeout(function () {
        google.maps.event.trigger(markers_map[0], 'click');
    }, 2000);
</script>
