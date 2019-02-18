<nav class="container navbar fixed-top navbar-expand-lg navbar-km-consult bg-white" data-toggle="affix" style="padding: 0 125px 0 125px;">
    <a class="navbar-brand" href="/">
        <img src="images/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">ÚVOD<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">O NÁS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">SLUŽBY</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">TEAM</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">KONTAKT</a>
            </li>
            @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="/logout">ODHLÁSENIE</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/login">PRIHLÁSENIE</a>
            </li>
            @endif
        </ul>
    </div>
</nav>

<script>
$(window).scroll(function() {
  /* affix after scrolling 100px */
  if ($(document).scrollTop() > 100) {
    $('.navbar').addClass('affix');
	$('.navbar-brand img').attr('src','images/logo-scroll.png'); //change src
  } else {
    $('.navbar').removeClass('affix');
	$('.navbar-brand img').attr('src','images/logo.png'); //change src
  }
});
</script>

