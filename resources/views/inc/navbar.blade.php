<nav class="container navbar navbar-main fixed-top navbar-expand-lg navbar-km-consult bg-white fixed-top-2" data-toggle="affix" style="padding: 0 125px 0px 125px">
    <a class="navbar-brand" href="{{asset('/')}}">
        <img src="{{asset('images/logo.png')}}" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul id="navigation" class="navbar-nav ml-auto">
            @foreach($menulist as $menu)
                @if(!count($menu['child']))
                <li class="nav-item">
                    <a id="{{ __($menu['id']) }}" class="nav-link" href="{{asset($menu['link'])}}">{{ __($menu['label']) }}</a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __($menu['label']) }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @foreach($menu['child'] as $children)
                        <a class="dropdown-item" href="{{asset($children['link'])}}">
                            {{ __($children['label']) }}
                        </a>
                    @endforeach
                    </div>
                    </li>
                @endif
            @endforeach

            @if(Auth::check())
            <li class="nav-item dropdown">
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


                    @endif
                    
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
                <a class="nav-link" href="{{asset('login')}}">PRIHLÁSENIE</a>
            </li>
            @endif
        </ul>
    </div>
</nav>
<nav class="container navbar fixed-top navbar-light">
<div class="row" style="width:100%;margin-left:0px;border-bottom: 1px solid #696868;">
<div class="col-12"><p style="margin:0;font-size: 12px; font-weight: 400;color:#949494" class="float-right">Informácie na telefónnom čísle: <b>+421 915 232 394</b></p></div>
</div>
</nav>
<div class="container text-center">
    @include('inc.messages')
</div>
<script>
    $(window).scroll(function () {
        /* affix after scrolling 100px */
        if ($(document).scrollTop() > 100) {
            $('.navbar-main').addClass('affix');
            $('.navbar-brand img').attr('src', "{{asset('images/logo-scroll.png')}}"); //change src
        } else {
            $('.navbar-main').removeClass('affix');
            $('.navbar-brand img').attr('src', "{{asset('images/logo.png')}}"); //change src
        }
    });

    $(function(){
        $('a').each(function(){
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); 
                $(this).parents('li').addClass('active');
            }
			if (window.location.href=="http://ipolak.nws.company/nws_paralaxcms/public/") {
                $('#uvod').addClass('active'); 
                $('#uvod').parents('li').addClass('active');
            }
        });
    });
</script>
