<div class="movie-wrapper">
@if ($torrent->tmdb != 0 && $torrent->tmdb != null)
    <div class="movie-overlay"></div>
@else
@endif

@if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
    <div class="movie-poster">
        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}" class="img-responsive" id="meta-poster">
    </div>
@else
    <div class="movie-poster">
        <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
            <img src="{{ ($meta && $meta->poster) ? \tmdb_image('poster_big', $meta->poster) : '/img/SLOshare/cartoon_no_image_400x600.jpg'; }}"
                 class="img-responsive" id="meta-poster">
        </a>
    </div>
@endif

@if ($torrent->tmdb != 0 && $torrent->tmdb != null || isset($meta) && $meta->url && $torrent->igdb !== 0 && $torrent->igdb !== null)

    <div class="meta-info">
        <div class="tags">
            {{ $torrent->category->name }}
        </div>

        <div class="movie-right">
            @if(isset($meta->networks) && $meta->networks->isNotEmpty())
                @php $network = $meta->networks->first() @endphp
                <div class="badge-user">
                    <a href="{{ route('torrents', ['view' => 'group', 'networkId' => $network->id]) }}">
                        @if(isset($network->logo))
                            <img class="img-responsive" src="{{ tmdb_image('logo_small', $network->logo) }}"
                                 title="{{ $network->name }}">
                        @else
                            {{ $network->name }}
                        @endif
                    </a>
                </div>
            @endif

            @if(isset($meta->companies) && $meta->companies->isNotEmpty())
                @php $company = $meta->companies->first() @endphp
                <div class="badge-user">
                    <a href="{{ route('torrents', ['view' => 'group', 'companyId' => $company->id]) }}">
                        @if(isset($company->logo))
                            <img class="img-responsive" src="{{ tmdb_image('logo_small', $company->logo) }}"
                                 title="{{ $company->name }}">
                        @else
                            {{ $company->name }}
                        @endif
                    </a>
                </div>
            @endif
        </div>

        <div class="movie-backdrop"
             style="background-image: url('{{ ($meta && $meta->backdrop) ? tmdb_image('back_big', $meta->backdrop) : '/img/SLOshare/cartoon_no_image_banner.jpg' }}');"></div>

        <div class="movie-top">
            <h1 class="movie-heading" style="margin-bottom: 0;">
                <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
                    <span class="text-bright text-bold"
                          style="font-size: 28px;">{{ $meta->name ?? 'Meta ni bila najdena' }}</span>
                </a>
                @if(isset($meta->first_air_date))
                    <span style="font-size: 28px;"> ({{ substr($meta->first_air_date, 0, 4) ?? '' }})</span>
                @endif
            </h1>

            <div class="movie-overview">
                {{ isset($meta->name) ? Str::limit($meta->overview, $limit = 350, $end = '...') : '' }}
            </div>
        </div>

        <div class="movie-bottom">
            <div class="movie-details">
                @if(!empty($creators = (new App\Services\Tmdb\Client\CartoonTv($torrent->tmdb))->get_creator()))
                    <span class="badge-user text-bold text-purple">
                        <i class="{{ config('other.font-awesome') }} fa-camera-movie"></i> Ustvarjalci:
                        @foreach($creators as $creator)
                            <a href="{{ route('mediahub.persons.show', ['id' => $creator['id']]) }}"
                               style="display: inline-block;">
                                {{ $creator['name'] }}
                            </a>
                            @if (! $loop->last)
                                ,
                            @endif
                        @endforeach
                    </span>
                @endif
                <br>
                @if ($torrent->imdb != 0 && $torrent->imdb != null)
                    <span class="badge-user text-bold">
                    <a href="https://www.imdb.com/title/tt{{ \str_pad((int) $torrent->imdb, \max(\strlen((int) $torrent->imdb), 7), '0', STR_PAD_LEFT) }}" title="IMDB" target="_blank">
                        <i class="{{ config('other.font-awesome') }} fa-film"></i> IMDB: {{ \str_pad((int) $torrent->imdb, \max(\strlen((int) $torrent->imdb), 7), '0', STR_PAD_LEFT) }}
                    </a>
                </span>
                @endif

                @if ($torrent->tmdb != 0 && $torrent->tmdb != null)
                    <span class="badge-user text-bold">
                    <a href="https://www.themoviedb.org/tv/{{ $torrent->tmdb }}" title="The Movie Database"
                       target="_blank">
                        <i class="{{ config('other.font-awesome') }} fa-film"></i> TMDB: {{ $torrent->tmdb }}
                    </a>
                </span>
                @endif

                @if ($torrent->mal != 0 && $torrent->mal != null)
                    <span class="badge-user text-bold">
                    <a href="https://myanimelist.net/anime/{{ $torrent->mal }}" title="MyAnimeList" target="_blank">
                        <i class="{{ config('other.font-awesome') }} fa-film"></i> MAL: {{ $torrent->mal }}</a>
                </span>
                @endif

                @if ($torrent->tvdb != 0 && $torrent->tvdb != null)
                    <span class="badge-user text-bold">
                    <a href="https://www.thetvdb.com/?tab=series&id={{ $torrent->tvdb }}" title="TheTVDB"
                       target="_blank">
                        <i class="{{ config('other.font-awesome') }} fa-film"></i> TVDB: {{ $torrent->tvdb }}
                    </a>
                </span>
                @endif

                @if (isset($trailer))
                    <span style="cursor: pointer;" class="badge-user text-bold show-trailer">
                        <a class="text-pink" title="{{ __('torrent.trailer') }}">{{ __('torrent.trailer') }}
                            <i class="{{ config('other.font-awesome') }} fa-external-link"></i>
                        </a>
                    </span>
                @endif
            </div>

            <div class="movie-details">
                @if(isset($meta) && !empty(trim($meta->homepage)))
                    <span class="badge-user text-bold">
                    <a href="{{ $meta->homepage }}" title="Homepage" rel="noopener noreferrer" target="_blank">
                        <i class="{{ config('other.font-awesome') }} fa-external-link-alt"></i> Domača stran
                    </a>
                </span>
                @endif

                <span class="badge-user text-bold text-orange">
                    Status: {{ $meta->status ?? 'Unknown' }}
                </span>

                @if (isset($meta->episode_run_time))
                    <span class="badge-user text-bold text-orange">
                    {{ __('torrent.runtime') }}: {{ $meta->episode_run_time }}
                        {{ __('common.minute') }}{{ __('common.plural-suffix') }}
                </span>
                @endif

                <span class="badge-user text-bold text-gold">{{ __('torrent.rating') }}:
                    <span class="movie-rating-stars">
                        <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    </span>
                    {{ $meta->vote_average ?? 0 }}/10 ({{ $meta->vote_count ?? 0 }} {{ __('torrent.votes') }})
                </span>
            </div>

            <div class="cast-list">
                @if (isset($meta->cast) && $meta->cast->isNotEmpty())
                    @foreach ($meta->cast->sortBy('order')->take(7) as $cast)
                        <div class="cast-item" style="max-width: 80px;">
                            <a href="{{ route('mediahub.persons.show', ['id' => $cast->id]) }}" class="badge-user">
                                <img class="img-responsive"
                                     src="{{ $cast->still ? tmdb_image('cast_face', $cast->still) : '/img/SLOshare/video_no_image_cast.jpg' }}"
                                     alt="{{ $cast->name }}">
                                <div class="cast-name">{{ $cast->name }}</div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@else
    <div class="meta-info">
        {{-- General Info Block --}}
        @include('torrent.partials.no_meta_general')
        <div class="torrent-buttons">
            @include('torrent.partials.buttons')
        </div>
    </div>
@endif
</div>
