@extends('layout.default')

@section('title')
    <title>{{ $season->name }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $season->name }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.cartoontvs.index') }}" class="breadcrumb__link">
            Risanke TV
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.cartoontvs.show', ['id' => $cartoontv->id]) }}" class="breadcrumb__link">
            {{ $cartoontv->name }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $season->name }}
    </li>
@endsection

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('mediahub.episodes') }}</h2>
        <div class="panel__body">
            @foreach($season->episodes as $episode)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card is-torrent" style="margin-top: 0; margin-bottom: 20px; height: auto;">
                            <div class="card_head">
                                <span class="badge-user text-bold" style="float:right;">
                                    Episode {{ $episode->episode_number }}
                                </span>
                            </div>
                            <div class="card_body">
                                <div class="body_poster">
                                    <img src="{{ isset($episode->still) ? tmdb_image('still_mid', $episode->still) : '/img/SLOshare/cartoon_mediahub_no_image_banner' }}"
                                            class="show-poster">
                                </div>
                                <div class="body_description" style=" height: 190px;">
                                    <h3 class="description_title">
                                        {{ $episode->name }} -
                                        @if($episode->air_date)
                                            <span class="text-bold text-pink"> {{ $episode->air_date }}</span>
                                        @endif
                                    </h3>
                                    <p class="description_plot">
                                        {{ $episode->overview }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('sidebar')
    <section class="panelV2">
        <h2 class="panel__heading">{{ $season->name }} ({{ $season->air_date }})</h2>
        <img
            src="{{ isset($season->poster) ? tmdb_image('cast_big', $season->poster) : '/img/SLOshare/cartoon_no_image_300x450.jpg' }}"
            alt="{{ $$cartoontv->name }}"
        >
        <div class="panel__body">
            {{ $season->overview }}
        </div>
        <dl class="key-value">
            <dt>Datum predvajanja</dt>
            <dd>{{ $season->air_date }}</dd>
        </dl>
    </section>
@endsection
