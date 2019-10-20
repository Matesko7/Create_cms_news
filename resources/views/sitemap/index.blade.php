<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="{{asset('/sitemap')}}">
@foreach($links as $link)
    <url>
        <loc>{{$link}}</loc>
        <lastmod>{{ date("Y-m-d") }}</lastmod>
        <changefreq>monthly</changefreq>
    </url>
@endforeach
</urlset>