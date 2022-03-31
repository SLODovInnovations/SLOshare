@extends('layout.default')

@section('title')
    <title>{{ __('common.subtitles') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('subtitles.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.subtitles') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div>
        @livewire('subtitle-search')
    </div>
@endsection