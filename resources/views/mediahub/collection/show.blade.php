@extends('layout.default')

@section('title')
    <title>{{ $collection->name }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $collection->name }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.collections.index') }}" class="breadcrumb__link">
            {{ __('mediahub.collections') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $collection->name }}
    </li>
@endsection

@section('content')
            {{-- Movie Meta Block --}}
            @if ($torrent->category->movie_meta)
                @include('mediahub.collections.partials.movie')
            @endif

            {{-- Cartoons Meta Block --}}
            @if ($torrent->category->cartoon_meta)
                @include('mediahub.collections.partials.cartoon')
            @endif

        <br>

        <div class="panel panel-chat shoutbox">
            <div class="panel-heading">
                <h4><i class="{{ config("other.font-awesome") }} fa-film"></i> Kolekcije</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td>
                            <section class="recommendations">
                                @foreach($collection->movie->sortBy('release_date') as $movie)
                                    <div class="item mini backdrop mini_card col-md-3">
                                        <div class="image_content">
                                            @php
                                                $torrent_temp = App\Models\Torrent::where('tmdb', '=', $movie->id)
                                                ->whereIn('category_id', function ($query) {
                                                $query->select('id')->from('categories')->where('movie_meta', '=', true);
                                                })->first()
                                            @endphp
                                            <a href="{{ route('torrents.similar', ['category_id' => $torrent_temp->category_id, 'tmdb' => $movie->id]) }}">
                                                <div>
                                                    <img class="backdrop"
                                                         src="{{ tmdb_image('poster_mid', $movie->poster) }}">
                                                </div>
                                                <div style=" margin-top: 8px;">
                                                    <span class="badge-extra"><i
                                                                class="fas fa-calendar text-purple"></i> {{ __('common.year') }}: {{ substr($movie->release_date, 0, 4) }}</span>
                                                    <span class="badge-extra"><i class="fas fa-star text-gold"></i> {{ __('torrent.rating') }}: {{ $movie->vote_average }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($collection->cartoon->sortBy('release_date') as $cartoon)
                                    <div class="item mini backdrop mini_card col-md-3">
                                        <div class="image_content">
                                            @php
                                                $torrent_temp = App\Models\Torrent::where('tmdb', '=', $cartoon->id)
                                                ->whereIn('category_id', function ($query) {
                                                $query->select('id')->from('categories')->where('cartoon_meta', '=', true);
                                                })->first()
                                            @endphp
                                            <a href="{{ route('torrents.similar', ['category_id' => $torrent_temp->category_id, 'tmdb' => $cartoon->id]) }}">
                                                <div>
                                                    <img class="backdrop"
                                                         src="{{ tmdb_image('poster_mid', $cartoon->poster) }}">
                                                </div>
                                                <div style=" margin-top: 8px;">
                                                    <span class="badge-extra"><i
                                                                class="fas fa-calendar text-purple"></i> {{ __('common.year') }}: {{ substr($cartoon->release_date, 0, 4) }}</span>
                                                    <span class="badge-extra"><i class="fas fa-star text-gold"></i> {{ __('torrent.rating') }}: {{ $cartoon->vote_average }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </section>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="torrent box container" id="comments">
        <div class="col-md-12 col-sm-12">
            <livewire:comments :model="$collection"/>
        </div>
    </div>
@endsection
