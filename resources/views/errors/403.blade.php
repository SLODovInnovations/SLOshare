@extends('errors.layout')

@section('title')
    NAPAKA 403: Prepovedano!
@stop

@section('container')
    <h1 class="mt-5 text-center">
        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-danger"></i> Dovoljenje zavrnjeno!
    </h1>

    <div class="separator"></div>

    <p class="text-center"> {{ $exception->getMessage() ?: 'Nimate dovoljenja za izvedbo tega dejanja!' }}</p>
@stop
