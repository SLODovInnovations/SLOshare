@extends('layout.default')

@section('title')
    <title>{{ __('common.genres') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Genres">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('mediahub.genres') }}
    </li>
@endsection

@section('content')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('common.genres') }}</h2>
        <div class="panel__body blocks">
            @foreach ($genres as $genre)
                <a href="{{ route('mediahub.genres.show', ['id' => $genre->id]) }}" style="padding: 0 2px;">
                    <div class="people media_blocks" style="background-color: rgba(0, 0, 0, 0.33);">
                        <h2 class="text-bold"> {{ $genre->name }}</h2>
                        <span style="background-color: #317aaf;"></span>
                        <h2 style="font-size: 14px;">
                            <i class="{{ config('other.font-awesome') }} fa-tv-retro"></i> {{ $genre->tv_count() }} {{ __('mediahub.shows') }}
                            |
                            <i class="{{ config('other.font-awesome') }} fa-tv-retro"></i> {{ $genre->cartoontv_count() }} {{ __('mediahub.cartoontvs') }}
                            |
                            <i class="{{ config('other.font-awesome') }} fa-film"></i> {{ $genre->movie_count() }} {{ __('mediahub.movies') }}
                            |
                            <i class="{{ config('other.font-awesome') }} fa-film"></i> {{ $genre->cartoon_count() }} {{ __('mediahub.cartoons') }}
                        </h2>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
