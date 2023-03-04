@extends('layout.default')

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.persons.index') }}" class="breadcrumb__link">
            {{ __('mediahub.persons') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $person->name }}
    </li>
@endsection

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('mediahub.movies') }} ({{ $person->movie->count() }})</h2>
        <div class="panel__body">
            <table class="table table-striped clearfix">
                <tbody>
                    @forelse($person->movie as $movie)
                        <tr>
                            <td class="col-sm-1">
                                <img src="{{ isset($movie->poster) ? tmdb_image('poster_small', $movie->poster) : '/img/SLOshare/no_image_cast_90x135.jpg' }}"
                                    alt="{{ $movie->name }}" class="img-responsive">
                            </td>
                            <td class="col-sm-5">
                                <i class="fa fa-eye text-green" aria-hidden="true"></i> <a
                                        href="{{ route('torrents', ['tmdbId' => $movie->id]) }}">{{ $movie->title }}</a><br>
                                <i class="fa fa-tags text-red" aria-hidden="true"></i>
                                <strong>
                                    @if ($movie->genres)
                                        @foreach ($movie->genres as $genre)
                                            {{ $genre->name }}
                                        @endforeach
                                    @endif
                                </strong>
                                <br>
                                <i class="fa fa-calendar text-blue" aria-hidden="true"></i>
                                <strong>{{ __('mediahub.release-date') }} </strong>{{ $movie->release_date }}<br>
                            </td>
                            <td class="col-xs-pull-6"><i class="fa fa-book text-gold" aria-hidden="true"></i>
                                <strong>{{ __('mediahub.plot') }} </strong>
                                {{ $movie->overview }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">{{ __('mediahub.no-data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('mediahub.shows') }} ({{ $person->tv->count() }})</h2>
        <div class="panel__body">
            <table class="table table-striped">
                <tbody>
                    @forelse($person->tv as $show)
                        <tr>
                            <td class="col-sm-1">
                                <img src="{{ isset($show->poster) ? tmdb_image('poster_small', $show->poster) : '/img/SLOshare/no_image_cast_90x135.jpg' }}"
                                    alt="{{ $show->name }}" class="img-responsive">
                            </td>
                            <td class="col-sm-5">
                                <i class="fa fa-eye text-green" aria-hidden="true"></i> <a
                                        href="{{ route('torrents', ['tmdbId' => $show->id]) }}">{{ $show->name }}</a><br>
                                <i class="fa fa-tags text-red" aria-hidden="true"></i>
                                <strong>
                                    @if ($show->genres)
                                        @foreach ($show->genres as $genre)
                                            {{ $genre->name }}
                                        @endforeach
                                    @endif
                                </strong>
                                <br>
                                <i class="fa fa-calendar text-blue" aria-hidden="true"></i>
                                <strong>{{ __('mediahub.release-date') }} </strong>{{ $show->first_air_date }}<br>
                            </td>
                            <td class="col-xs-pull-6"><i class="fa fa-book text-gold" aria-hidden="true"></i>
                                <strong>{{ __('mediahub.plot') }} </strong>
                                {{ $show->overview }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">{{ __('mediahub.no-data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('sidebar')
    <section class="panelV2">
        <h2 class="panel__heading">{{ $person->name }}</h2>
        <img
            src="{{ isset($person->still) ? tmdb_image('cast_big', $person->still) : '/img/SLOshare/no_image_cast_300x450.jpg' }}"
            alt="{{ $person->name }}"
        >
        <div class="panel__body">{{ $person->biography ?? 'Ni biografije' }}</div>
        <dl class="key-value">
            <dt>{{ __('mediahub.born') }}</dt>
            <dd>{{ $person->birthday ?? __('common.unknown') }}</dd>
            <dt>Kraj rojstva</dt>
            <dd>{{ $person->place_of_birth ?? __('common.unknown') }}</dd>
            <dt>{{ __('mediahub.movie-credits') }}</dt>
            <dd>{{ $person->movie->count() ?? '0' }}</dd>
            <dt>{{ __('mediahub.first-seen') }} </dt>
            <dd>
                <a href="{{ route('torrents', ['tmdbId' => $person->movie->first()->id ?? '0']) }}">
                    {{ $person->movie->first()->title ?? 'N/A'}}
                </a>
            </dd>
            <dt>{{ __('mediahub.latest-project') }}</dt>
            <dd>
                <a href="{{ route('torrents', ['tmdbId' => $person->movie->last()->id ?? '0']) }}">
                    {{ $person->movie->last()->title ?? 'N/A' }}
                </a>
            </dd>
            <dt>{{ __('mediahub.tv-credits') }}</dt>
            <dd>{{ $person->tv->count() ?? '0' }}</dd>
            <dt>{{ __('mediahub.first-seen') }}</dt>
            <dd>
                Notri
                <a href="{{ route('torrents', ['tmdbId' => $person->tv->first()->id ?? '0']) }}">
                    {{ $person->tv->first()->name ?? 'N/A'}}
                </a>
            </dd>
            <dt>{{ __('mediahub.latest-project') }}</dt>
            <dd>
                Zadnji nastop
                <a href="{{ route('torrents', ['tmdbId' => $person->tv->last()->id ?? '0']) }}">
                    {{ $person->tv->last()->name ?? 'N/A' }}
                </a>
            </dd>
        </dl>
    </section>
@endsection
