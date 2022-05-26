<div class="col-md-10 col-sm-10 col-md-offset-1">

                        <!-- Buttons -->
                        <ul class="nav nav-tabs-user mb-5-user" role="tablist">
                             <li class="active">
                                <a href="#seeders" role="tab" data-toggle="tab" aria-expanded="false">
                                    <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i> {{ __('sloshare.home-seeders-title') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="#leechers" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i> {{ __('sloshare.home-leechers-title') }}
                                </a>
                            </li>
                        </ul>
                        <!-- Buttons -->
<div class="tab-content">

    <div class="tab-pane fade active in" id="seeders">
        <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">





    @foreach ($seeded as $seed)

					@php $meta = null; @endphp
					@if ($seed->category->tv_meta)
						@if ($seed->tmdb || $seed->tmdb != 0)
							@php $meta = App\Models\Tv::where('id', '=', $seed->tmdb)->first(); @endphp
						@endif
					@endif
					@if ($seed->category->movie_meta)
						@if ($seed->tmdb || $seed->tmdb != 0)
							@php $meta = App\Models\Movie::where('id', '=', $seed->tmdb)->first(); @endphp
						@endif
					@endif
					@if ($seed->category->game_meta)
						@if ($seed->igdb || $seed->igdb != 0)
							@php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($seed->igdb); @endphp
						@endif
					@endif

			<div class="gallery-item"
			@if ($seed->category->movie_meta || $seed->category->tv_meta)
			    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_holder_400x600.jpg' }}"
			        class="show-poster" alt="{{ __('torrent.poster') }}>
            @endif

            @if ($seed->category->game_meta && isset($meta) && $meta->cover['image_id'] && $meta->name)
                style="background-image: url('https://images.igdb.com/igdb/image/upload/t_cover_big/{{ $meta->cover['image_id'] }}.jpg')
                    class="show-poster"
                    data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                    data-image='<img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover['image_id'] }}.jpg"
					    alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                    class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
            @endif


            @if(file_exists(public_path().'/files/img/torrent-cover_'.$seed->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $seed->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif

			@if ($seed->category->music_meta)
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$seed->id.'.jpg'))
                style="background-image: url('{{ url('files/img/torrent-cover_' . $seed->id . '.jpg') }}');">
			@endif
            @endif
				<div class="release-info">

				    @if ($seed->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $seed->category->id]) }}" class="release-info-quality quality-sloshare">{{ $seed->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $seed->category->id]) }}" class="release-info-quality quality-sloshare">{{ $seed->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $seed->id]) }}"title="{{ $seed->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($seed->name, 50))</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $seed->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $seed->comments_count }}</span></div>

						@if ($seed->category->game_meta)
						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						@endif
                        @if ($seed->tmdb != 0 && $seed->tmdb != null)
                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                        @endif

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $seed->created_at->getTimestamp()) }} | {{ date('H:m', $seed->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $seed->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $seed->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $seed->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $seed->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $seed->leechers }}</span>
						</div>
					</div>
				</div>
				<!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			</div>
@endforeach

<!--                <a class="left carousel-control">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">{{ __("common.previous") }}</span>
                </a>
                <a class="right carousel-control">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">{{ __("common.next") }}</span>
                </a>-->
            </div>
        </div>
    </div>

        <div class="tab-pane fade" id="leechers">
            <div class="clearfix visible-sm-block"></div>
            <div class="panel panel-chat shoutbox">
                <div id="myCarousel" class="keen-slider-slo">





    @foreach ($leeched as $leech)

    					@php $meta = null; @endphp
    					@if ($leech->category->tv_meta)
    						@if ($leech->tmdb || $leech->tmdb != 0)
    							@php $meta = App\Models\Tv::where('id', '=', $leech->tmdb)->first(); @endphp
    						@endif
    					@endif
    					@if ($leech->category->movie_meta)
    						@if ($leech->tmdb || $leech->tmdb != 0)
    							@php $meta = App\Models\Movie::where('id', '=', $leech->tmdb)->first(); @endphp
    						@endif
    					@endif
    					@if ($leech->category->game_meta)
    						@if ($leech->igdb || $leech->igdb != 0)
    							@php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($leech->igdb); @endphp
    						@endif
    					@endif

    			<div class="gallery-item"
			@if ($leech->category->movie_meta || $leech->category->tv_meta)
			    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_holder_400x600.jpg' }}"
			        class="show-poster" alt="{{ __('torrent.poster') }}>
            @endif

            @if ($leech->category->game_meta && isset($meta) && $meta->cover['image_id'] && $meta->name)
                style="background-image: url('https://images.igdb.com/igdb/image/upload/t_cover_big/{{ $meta->cover['image_id'] }}.jpg')
                    class="show-poster"
                    data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                    data-image='<img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover['image_id'] }}.jpg"
					    alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                    class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
            @endif


            @if(file_exists(public_path().'/files/img/torrent-cover_'.$leech->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $leech->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif

			@if ($leech->category->music_meta)
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$leech->id.'.jpg'))
                style="background-image: url('{{ url('files/img/torrent-cover_' . $leech->id . '.jpg') }}');">
			@endif
            @endif
    				<div class="release-info">

    				    @if ($leech->free == '1' || config('other.freeleech') == '1')
    					<a href="{{ route('categories.show', ['id' => $leech->category->id]) }}" class="release-info-quality quality-sloshare">{{ $leech->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
    					@else
    					<a href="{{ route('categories.show', ['id' => $leech->category->id]) }}" class="release-info-quality quality-sloshare">{{ $leech->category->name }}</a>
                        @endif

    					<a href="{{ route('torrent', ['id' => $leech->id]) }}"title="{{ $leech->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($leech->name, 50))</a>
    					<div class="release-info-container">
    						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $leech->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $leech->comments_count }}</span></div>

    						@if ($leech->category->game_meta)
    						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
    						@endif
                            @if ($leech->tmdb != 0 && $leech->tmdb != null)
                            <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                            @endif

    						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $leech->created_at->getTimestamp()) }} | {{ date('H:m', $leech->created_at->getTimestamp()) }}</div>
    						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $leech->user->username }}</div>
    					</div>
    					<div class="release-info-rating">
    						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $leech->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $leech->getSize() }}</a>
    						<div style="float: right;">
    							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $leech->seeders }}</span>
    							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $leech->leechers }}</span>
    						</div>
    					</div>
    				</div>
    				<!--<span class="torrent-new" title="" data-title-tooltip></span>-->
    			</div>
    @endforeach

    <!--                <a class="left carousel-control">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">{{ __("common.previous") }}</span>
                    </a>
                    <a class="right carousel-control">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">{{ __("common.next") }}</span>
                    </a>-->
                </div>
            </div>
        </div>
    </div>
</div>
