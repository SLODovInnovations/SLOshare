<div class="col-md-6">
    <div class="card is-torrent">
        <div class="card_head">

        </div>
        <div class="card_body">
            <div class="body_poster">
                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                            class="show-poster"  alt="{{ __('torrent.poster') }}">
                    @else
                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_big', $meta->poster) : '/img/movie_no_image_SLOshare/600x900.jpg' }}"
                            class="show-poster" alt="{{ __('torrent.poster') }}">
                    @endif
                @endif

                @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                            class="show-poster"  alt="{{ __('torrent.poster') }}">
                    @else
                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_big', $meta->poster) : '/img/SLOshare/cartoon_no_image_600x900.jpg' }}"
                            class="show-poster" alt="{{ __('torrent.poster') }}">
                    @endif
                @endif

                @if ($torrent->category->game_meta && isset($meta) && $meta->cover->image_id && $meta->name)
                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                            class="show-poster"  alt="{{ __('torrent.poster') }}">
                    @else
                        <img src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_original/'.$meta->cover['image_id'].'.jpg' : '/img/SLOshare/games_no_image_600x900.jpg' }}"
                            class="show-poster"
                            data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                            data-image='<img src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_original/'.$meta->cover['image_id'].'.jpg' : '/img/SLOshare/games_no_image_600x900.jpg' }}" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                            class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                    @endif
                @endif

                @if ($torrent->category->music_meta)
                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                            class="torrent-poster-img-small show-poster"  alt="{{ __('torrent.poster') }}">
                    @else
                        <img src="/img/SLOshare/music_no_image_600x900.jpg" class="show-poster"
                            data-name='<i style="color: #a5a5a5;">N/A</i>'
                            data-image='<img src="/img/SLOshare/music_no_image_600x900.jpg" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                            class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                    @endif
                @endif

                @if ($torrent->category->no_meta)
                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                            class="torrent-poster-img-small show-poster"  alt="{{ __('torrent.poster') }}">
                    @else
                        <img src="/img/SLOshare/meta_no_image_600x900.jpg" class="show-poster"
                            data-name='<i style="color: #a5a5a5;">N/A</i>'
                            data-image='<img src="/img/SLOshare/meta_no_image_600x900.jpg" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                            class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                    @endif
                @endif
            </div>
            <div class="body_description">
                <h3 class="description_title">
                    <a href="{{ route('torrent', ['id' => $torrent->id]) }}">
                        @if ($torrent->category->movie_meta)
                            {{ $meta->title ?? 'Unknown' }}
                        @endif
                        @if ($torrent->category->cartoon_meta)
                            {{ $meta->title ?? 'Unknown' }}
                        @endif
                        @if ($torrent->category->tv_meta)
                            {{ $meta->name ?? 'Unknown' }}
                        @endif
                        @if ($torrent->category->cartoontv_meta)
                            {{ $meta->name ?? 'Unknown' }}
                        @endif
                        @if($torrent->category->movie_meta)
                            <span class="text-bold text-pink"> {{ substr($meta->release_date ?? '', 0, 4) ?? '' }}</span>
                        @endif
                        @if($torrent->category->cartoon_meta)
                            <span class="text-bold text-pink"> {{ substr($meta->release_date ?? '', 0, 4) ?? '' }}</span>
                        @endif
                        @if($torrent->category->tv_meta)
                            <span class="text-bold text-pink"> {{ substr($meta->first_air_date ?? '', 0, 4) ?? '' }}</span>
                        @endif
                        @if($torrent->category->cartoontv_meta)
                            <span class="text-bold text-pink"> {{ substr($meta->first_air_date ?? '', 0, 4) ?? '' }}</span>
                        @endif
                    </a>
                </h3>
                @if (($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) && isset($meta->genres))
                    @foreach ($meta->genres as $genre)
                        <span class="genre-label">{{ $genre->name }}</span>
                    @endforeach
                @endif
                <p class="description_plot">
                    {{ $meta->overview ?? '' }}
                </p>
            </div>
        </div>
        <div class="card_footer">
			<span class="badge-user text-bold" style="float: right;">
				<i class="{{ config('other.font-awesome') }} fa-thumbs-up text-gold"></i>
				{{ $meta->vote_average ?? 0 }}/10 ({{ $meta->vote_count ?? 0 }} {{ __('torrent.votes') }})
			</span>
        </div>
    </div>
</div>