<header class="main-head">
    <nav class="navbar bg-white justify-content-center">
        <a href="tel:0918 683 202" class="col-lg">
            <p class="navbar-brand contact">0918 683 202</p>
            <i class="fas fa-phone-square contact-icon"></i>
        </a>
        <div class="row col-lg main-links">
            @foreach($menulist as $menu)
            <a href="{{asset($menu['link'])}}" class="col-lg" id="{{ __($menu['label']) }}">
                <p class="nav-item">{{ __($menu['label']) }}</p>
            </a>
            @endforeach

            @if (App::isLocale('sk'))
                <a href="{{asset('setlocale/en')}}" class="col-lg" id="locale">
                    <p class="nav-item">EN</p>
                </a>
	        @else
                <a href="{{asset('setlocale/sk')}}" class="col-lg" id="locale">
                    <p class="nav-item">SK</p>
                </a>
            @endif

            @if(Auth::check())
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="user_info">
                    <a class="dropdown-item" href="{{ route('userProfile') }}">
                        {{ __('PROFIL') }}
                    </a>

                    @if( Auth::user()->hasAnyRole(['admin','editor']))
                    <a class="dropdown-item" href="{{asset('admin/articles')}}">{{ __('Články') }}</a>
                    @endif

                    @if( Auth::user()->hasrole('admin') )
                    <a class="dropdown-item" href="{{asset('admin/users')}}">{{ __('Uživatelia') }}</a>

                    <a class="dropdown-item" href="{{asset('admin/categories')}}">{{ __('Kategórie') }}</a>

                    <a class="dropdown-item" href="{{asset('admin/menu')}}">{{ __('Menu') }}</a>

                    <a class="dropdown-item" href="{{asset('admin/comments')}}">{{ __('Komenty') }}</a>

                    <a class="dropdown-item" href="{{asset('admin/selectedarticles')}}">{{ __('Vybrané články') }}</a>

                    <a class="dropdown-item" href="{{asset('admin/carousel')}}">{{ __('Carousel') }}</a>
                    
                    @endif
                    
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                        {{ __('ODHLÁSENIE') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <a href="{{asset('admin_part')}}" class="col-lg" id="admin">
                        <p class="nav-item">{{ __('Admin') }}</p>
                    </a>
            @else
                 <a href="{{asset('login')}}" class="col-lg">
                <p class="nav-item">PRIHLÁSENIE</p>
                </a>
            @endif
        </div>
        <a href="mailto:ba.bobova@gmail.com" class="col-lg">
            <i class="fas fa-envelope contact-icon"></i>
            <p class="navbar-brand contact">ba.bobova@gmail.com</p>
        </a>
    </nav>

    <div class="row bg-white justify-content-center header-bottom">
        <div class="col-md row justify-content-center align-items-center social-wrap">
            <a href="#"><i class="fas fa-search"></i></a>
        </div>

        <div class="col-md row justify-content-center align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 248.81 49.99">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #fff;
                        }

                    </style>
                </defs>
                <title>Asset 2arrow-down</title>
                <g id="Layer_2" data-name="Layer 2">
                    <g id="Layer_1-2" data-name="Layer 1">
                        <path class="cls-1"
                            d="M248.81,0H0S27.9,2.17,53.49,16.42C78.22,30.19,104.26,49.87,124.32,50h.17c20.06-.11,46.1-19.79,70.83-33.57C220.9,2.17,248.81,0,248.81,0Z" />
                    </g>
                </g>
            </svg>
            <img src="{{asset('grafika/grafika/na_boboch.png')}}" alt="logo" draggable="false" class="logo">
        </div>

        <div class="col row justify-content-center align-items-center social-wrap">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class=" ml-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class=" ml-2"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
    
    @if(Route::current()->getName() == 'index')
    <div class="jumbotron jumbotron-fluid">
      <div class="row justify-content-center">
        <img src="{{asset('/grafika/grafika/star-slider.png')}}" alt="" class="star mr-4">
        <h3 class="welcome-text">Vitajte na bobovej dráhe</h3>
        <img src="{{asset('/grafika/grafika/star-slider.png')}}" alt="" class="star ml-4">
      </div>
      <h1 class="main-heading">Adrenalínová<br>zábava pre<br>všetkých</h1>
      <button type="button" class="btn btn-info show-more">Viac o ponuke</button>
      @endif
</div>

</header>
