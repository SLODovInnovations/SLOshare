@extends('layout.default')

@section('title')
    <title>{{ __('torrent.categories') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Kategorije">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a class="breadcrumb__link" href="{{ route('categories.index') }}">
            {{ __('torrent.categories') }}
        </a>
    </li>
@endsection

@section('nav-tabs')
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('torrents') }}">
            Seznam
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('cards') }}">
            Kartice
        </a>
    </li>
    <li class="nav-tab--active">
        <a class="nav-tab--active__link" href="{{ route('categories.index') }}">
            Kategorije
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('grouped') }}">
            Skupine
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('top10.index') }}">
            Top 10
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('rss.index') }}">
            {{ __('rss.rss') }}
        </a>
    </li>
@endsection

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('torrent.categories') }}</h2>
        <div class="panel__body blocks" style="justify-content: center;">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', ['id' => $category->id]) }}" class="">
                    <div class="movie media_blocks" style="background-color: rgba(0, 0, 0, 0.33);">
                        <h2>
                            @if ($category->image != null)
                                <img src="{{ url('files/img/' . $category->image) }}" alt="{{ $category->name }}">
                            @else
                                <i class="{{ $category->icon }}"></i>
                            @endif
                            {{ $category->name }}
                        </h2>
                        <span style="background-color: #01d277;"></span>
                        <h2 style="font-size: 20px;">{{ $category->torrents_count }}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection