@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                {{ __('Pred pokračovanim si skontrolujte svoj email a potvrdte verfikačný link.') }}
                {{ __('Ak ste email s verifikačným linkom nedostali') }}, <a href="{{ route('verification.resend') }}">{{
                    __('kliknite sem na zaslanie nového') }}</a>.
            </div>
        </div>
    </div>
    <br>
</div>
@endsection
