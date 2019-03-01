@extends('layout.app')

@section('content')
<div class="container">
    <div class="text-center">
        <a class="sub-nav" href="{{ route('login') }}">{{ __('Prihlásenie') }}</a>
        <a class="sub-nav" href="{{ route('register') }}">{{ __('Registrácia') }}</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Zadajte svoj e-mail')
                            }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="email" value="{{ old('email') }}" required>
                            <i>Obratom Vám zašleme e-mail s potvrdzovacím odkazom, ktorý Vám vygeneruje a pošle nové
                                heslo.</i>
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4 text-center">
                            <button type="submit" class="btn">
                                {{ __('Odoslať') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @endsection
