@extends('layout.default')

@section('title')
    <title>{{ $torrent->name }} - {{ __('torrent.torrents') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('torrent.meta-desc', ['name' => $torrent->name]) }}!">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('torrent.torrents') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('torrent', ['id' => $torrent->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $torrent->name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div id="torrent-page">
            {{-- Title Torrent --}}
            @include('torrent.partials.name')

            {{-- Tables Torrent --}}
            @include('torrent.partials.tables')

        <div class="meta-wrapper box container" id="meta-info">
            {{-- Movie Meta Block --}}
            @if ($torrent->category->movie_meta)
                @include('torrent.partials.movie_meta')
            @endif

            {{-- TV Meta Block --}}
            @if ($torrent->category->tv_meta)
                @include('torrent.partials.tv_meta')
            @endif

            {{-- Game Meta Block --}}
            @if ($torrent->category->game_meta)
                @include('torrent.partials.game_meta')
            @endif
            
            {{-- Music Meta Block --}}
            @if ($torrent->category->music_meta)
                @include('torrent.partials.music_meta')
            @endif

            {{-- No Meta Block --}}
            @if ($torrent->category->no_meta)
                @include('torrent.partials.no_meta')
            @endif

@if ($torrent->tmdb != 0 && $torrent->tmdb != null || isset($meta) && $meta->url && $torrent->igdb !== 0 && $torrent->igdb !== null)
            <div style="padding: 10px; position: relative;">
                <div class="vibrant-overlay"></div>
                <div class="button-overlay"></div>
            </div>
            <div class="torrent-buttons">
                @include('torrent.partials.buttons')
            </div>
        </div>
@else
<div style="padding: 10px;"></div>
@endif

        <div class="meta-general box container">
            {{-- Tools Block --}}
            @if (auth()->user()->group->is_modo || auth()->user()->id === $uploader->id || auth()->user()->group->is_internal)
                @include('torrent.partials.tools')
            @endif

            {{-- Audits Block --}}
            @if (auth()->user()->group->is_modo)
                @include('torrent.partials.audits')
            @endif

            {{-- General Info Block --}}
            @include('torrent.partials.general')

            {{-- MediaInfo Block --}}
            @if ($torrent->mediainfo !== null)
                @include('torrent.partials.mediainfo')
            @endif

            {{-- BDInfo Block --}}
            @if ($torrent->bdinfo !== null)
                @include('torrent.partials.bdinfo')
            @endif

            {{-- Description Block --}}
            @include('torrent.partials.description')

            {{-- Subtitles Block --}}
            @if($torrent->category->movie_meta || $torrent->category->tv_meta)
                @include('torrent.partials.subtitles')
            @endif

            <!--{{-- TipJar Block --}}
            @include('torrent.partials.tipjar')-->

            {{-- Extra Meta Block --}}
            @if($torrent->category->movie_meta || $torrent->category->tv_meta)
                @include('torrent.partials.extra_meta')
            @endif
        </div>

        <div class="torrent box container" id="comments">
            {{-- Commments Block --}}
            @include('torrent.partials.comments')
        </div>

        {{-- Modals Block --}}
        @include('torrent.torrent_modals', ['user' => $user, 'torrent' => $torrent])
    </div>
@endsection

@section('javascripts')
    <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce() }}">
      $(document).ready(function () {
        $('#content').wysibb({})
      })
    </script>

    @if (isset($trailer))
        <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce() }}">
          $('.show-trailer').each(function () {
            $(this).off('click')
            $(this).on('click', function (e) {
              e.preventDefault()
              Swal.fire({
                showConfirmButton: false,
                showCloseButton: true,
                background: 'rgb(35,35,35)',
                width: 970,
                html: '<iframe width="930" height="523" src="{{ $trailer }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>',
                title: '<i style="color: #a5a5a5;">Trailer</i>',
                text: ''
              })
            })
          })
        </script>
    @endif
@endsection
