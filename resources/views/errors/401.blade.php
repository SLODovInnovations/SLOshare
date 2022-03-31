@extends('errors.layout')

@section('title')
    NAPAKA 401: Nepooblaščeno!
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-warning"></i> NAPAKA 401: Nepooblaščeno!
    </h1>

    <div class="separator"></div>

    <p class="text-center">
        {{ $exception->getMessage() ?: 'Odziv kode napake za manjkajoč ali neveljaven žeton za preverjanje pristnosti.' }}</p>
@stop
