@extends('layout.default')

@section('title')
    <title>{{ __('articles.articles') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('articles.meta-articles') }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">
        {{ __('articles.articles') }}
    </li>
@endsection

@section('content')
    <div class="container box">
        @foreach ($articles as $article)
            <div class="well">
                <a href="{{ route('articles.show', ['id' => $article->id]) }}"
                   style=" float: right; margin-right: 10px;">
                    @if ( ! is_null($article->image))
                        <img src="{{ url('files/img/' . $article->image) }}" alt="{{ $article->title }}">
                    @else
                        <img src="{{ url('img/missing-image.png') }}" alt="{{ $article->title }}">
                    @endif
                </a>

                <h1 class="text-bold" style="display: inline ;">{{ $article->title }}</h1>

                <p class="text-muted">
                    <em>{{ __('articles.published-at') }} {{ date('d.m.Y', $article->created_at->getTimestamp()) }} | {{ date('H:m:s', $article->created_at->getTimestamp()) }}</em>
                </p>

                <p style="margin-top: 20px;">
                    @joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($article->content), 150))...
                </p>

                <div class="text-center">
                    <a href="{{ route('articles.show', ['id' => $article->id]) }}" class="btn btn-success">
                        {{ __('articles.read-more') }}
                    </a>
                </div>
            </div>
        @endforeach
        <div class="text-center">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
