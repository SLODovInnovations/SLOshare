@extends('errors.layout')

@section('title')
    NAPAKA 502: Slab prehod!
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-warning"></i> NAPAKA 502: Slab prehod!
    </h1>

    <div class="separator"></div>

    <p class="text-center">
        {{ $exception->getMessage() ?:
            'Strežnik je, medtem ko je deloval kot prehod ali proxy, prejel neveljaven odgovor od
            navzgornji strežnik, do katerega je dostopal pri poskusu izpolnitve zahteve.' }}
    </p>
@stop
