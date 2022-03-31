@extends('errors.layout')

@section('title')
    NAPAKA 444
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-warning"></i> NAPAKA 444
    </h1>

    <div class="separator"></div>

    <p class="text-center">{{ $exception->getMessage() ?: 'POVEZAVA ZAPRTA IN JE BREZ ODGOVORA.' }}</p>
@stop
