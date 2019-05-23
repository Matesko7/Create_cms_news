@extends('layout.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{asset('grafika/css/blog-post.css')}}">
</head>

<section id="post-head">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg">
                <nav class="breadcrumb custom-breadcrumb-nav">
                    <a href="{{ route('register') }}" class="breadcrumb-item">
                        <h5 class="post-title title">Registrácia</h5>
                    </a>
                </nav>
                <h2 class="post-heading heading">Prihlásenie</h2>
            </div>
        </div>
    </div>
</section>

@guest
<section id="benefits">
  
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Heslo') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                required>

                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4 text-center">
                            <input type="submit" value="Prihlásiť" name="Odoslať" class="btn btn-info show-more">

                            @if (Route::has('password.request'))
                            <a class="btn-link" href="{{ route('password.request') }}">
                                {{ __('Zobudli ste heslo?') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endguest


@endsection
