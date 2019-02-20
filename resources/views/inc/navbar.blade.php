<nav class="container navbar fixed-top navbar-expand-lg navbar-km-consult bg-white" data-toggle="affix" style="padding: 0 125px 0 125px;">
    <a class="navbar-brand" href="/">
        <img src="/images/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">úvod<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">o nás</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">služby</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">team</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">kontakt</a>
            </li>
            @if(Auth::check())
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('userProfile') }}">
                        {{ __('PROFIL') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                        {{ __('ODHLÁSENIE') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="/login">PRIHLÁSENIE</a>
            </li>
            @endif
        </ul>
    </div>
</nav>
<div class="container text-center">
    @include('inc.messages');
</div>
<script>
    $(window).scroll(function () {
        /* affix after scrolling 100px */
        if ($(document).scrollTop() > 100) {
            $('.navbar').addClass('affix');
            $('.navbar-brand img').attr('src', '/images/logo-scroll.png'); //change src
        } else {
            $('.navbar').removeClass('affix');
            $('.navbar-brand img').attr('src', '/images/logo.png'); //change src
        }
    });

</script>
