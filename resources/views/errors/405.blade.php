@extends('errors.layout')

@section('title')
    NAPAKA 405: Metoda ni dovoljena!
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-warning"></i> NAPAKA 405: Metoda ni
        dovoljena!
    </h1>

    <div class="separator"></div>

    <p class="text-center">
        {{ $exception->getMessage() ?: 'Metoda, ki jo poskušate, je uporaba, ta strežnik ne dovoljuje.' }}</p>
@stop
