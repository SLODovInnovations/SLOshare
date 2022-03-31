@extends('errors.layout')

@section('title')
    NAPAKA 404: Stran ni najdena
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-question-circle text-warning"></i> NAPAKA 404: Stran ni najdena
    </h1>

    <div class="separator"></div>

    <p class="text-center">
        {{ $exception->getMessage() ?:
            'Zahtevane strani ni mogoče najti! Niste prepričani, kaj iščete, vendar preverite
                naslov in poskusite znova!' }}
    </p>
@stop
