@extends('errors.layout')

@section('title')
    NAPAKA 500: Napaka notranjega strežnika
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-cog fa-spin text-danger"></i> NAPAKA 500: Napaka notranjega strežnika!
    </h1>

    <div class="separator"></div>

    <p class="text-center">Naš strežnik je naletel na notranjo napako. <br>Oprostite za nevšečnosti</p>
@stop
