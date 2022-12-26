@extends('layout.default')

@section('title')
    <title>Risanke TV</title>
@endsection

@section('meta')
    <meta name="description" content="Risanke TV">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        Risanke TV
    </li>
@endsection

@section('content')
    <div class="box container">
        @livewire('cartoon-tv-search')
    </div>
@endsection