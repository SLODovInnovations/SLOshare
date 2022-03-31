@extends('errors.layout')

@section('title')
    NAPAKA 503: Storitev ni na voljo!
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-warning"></i> NAPAKA 503: Storitev ni na
        voljo!
    </h1>

    <div class="separator"></div>

    <p class="text-center">
        {{ $exception->getMessage() ?: 'Oprostite, izvajamo vzdrževalna dela. Kmalu bomo nazaj.' }}
    </p>
@stop
