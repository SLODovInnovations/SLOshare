@extends('errors.layout')

@section('title')
    NAPAKA 400: Slaba prošnja!
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-warning"></i> NAPAKA 400: Slaba prošnja!
    </h1>

    <div class="separator"></div>

    <p class="text-center">
    {{ $exception->getMessage() ?:
        'Strežnik ni mogel razumeti zahteve zaradi napačno oblikovane sintakse.
            <br> Stranka NE SME ponoviti zahteve brez sprememb.
        </p>' }}
@stop
