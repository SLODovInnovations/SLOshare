<div class="col-md-10 col-sm-10 col-md-offset-1">

                        <!-- Buttons -->
                        <ul class="nav nav-tabs-user mb-5-user" role="tablist">
                             <li class="active">
                                <a href="#new-sloshare" role="tab" data-toggle="tab" aria-expanded="false">
                                    <img src="{{ url('/icon-torrent.png') }}"> {{ __('sloshare.home-newsloshare-title') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="#video" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-film"></i> {{ __('sloshare.home-movie-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#tvseries" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-tv-retro"></i> {{ __('sloshare.home-tvseries-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#games" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-gamepad"></i> {{ __('sloshare.home-game-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#applications" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-compact-disc"></i> {{ __('sloshare.home-applications-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#cartoons" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-baby"></i> {{ __('sloshare.home-cartoons-title') }}
                                </a>
                            </li>
                             <li class="">
                                <a href="#xxx" role="tab" data-toggle="tab" aria-expanded="true">
                                    <i class="{{ config('other.font-awesome') }} fa-heart"></i> {{ __('sloshare.home-xxx-title') }}
                                </a>
                            </li>
                        </ul>
                        <!-- Buttons -->
<div class="tab-content">

    <div class="tab-pane fade active in" id="new-sloshare">
        <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">





            @foreach($newsloshare as $newslo)
                @php $meta = null @endphp
                @if ($newslo->category->tv_meta)
                    @if ($newslo->tmdb || $newslo->tmdb != 0)
                        @php $meta = cache()->remember('tvmeta:'.$newslo->tmdb.$newslo->category_id, 3_600, fn () => App\Models\Tv::select(['id', 'poster', 'vote_average'])->where('id', '=', $newslo->tmdb)->first()) @endphp
                    @endif
                @endif
                @if ($newslo->category->movie_meta)
                    @if ($newslo->tmdb || $newslo->tmdb != 0)
                        @php $meta = cache()->remember('moviemeta:'.$newslo->tmdb.$newslo->category_id, 3_600, fn () => App\Models\Movie::select(['id', 'poster', 'vote_average'])->where('id', '=', $newslo->tmdb)->first()) @endphp
                    @endif
                @endif
                @if ($newslo->category->game_meta)
                    @if ($newslo->igdb || $newslo->igdb != 0)
                        @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($newslo->igdb) @endphp
                    @endif
                @endif

			<div class="gallery-item"
			@if ($newslo->category->movie_meta || $newslo->category->tv_meta)
			    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_holder_400x600.jpg' }}"
			        class="show-poster" alt="{{ __('torrent.poster') }}>
            @endif

            @if ($newslo->category->game_meta && isset($meta) && $meta->cover['image_id'] && $meta->name)
                style="background-image: url('https://images.igdb.com/igdb/image/upload/t_cover_big/{{ $meta->cover['image_id'] }}.jpg')
                    class="show-poster"
                    data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                    data-image='<img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover['image_id'] }}.jpg"
					    alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                    class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
            @endif


            @if(file_exists(public_path().'/files/img/torrent-cover_'.$newslo->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $newslo->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif

			@if ($newslo->category->music_meta)
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$newslo->id.'.jpg'))
                style="background-image: url('{{ url('files/img/torrent-cover_' . $newslo->id . '.jpg') }}');">
			@endif
            @endif

				<div class="release-info">

				    @if ($newslo->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $newslo->category->id]) }}" class="release-info-quality quality-sloshare">{{ $newslo->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $newslo->category->id]) }}" class="release-info-quality quality-sloshare">{{ $newslo->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $newslo->id]) }}"title="{{ $newslo->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($newslo->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $newslo->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $newslo->comments_count }}</span></div>

						@if ($newslo->category->game_meta)
						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						@endif
                        @if ($newslo->tmdb != 0 && $newslo->tmdb != null)
                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                        @endif

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $newslo->created_at->getTimestamp()) }} | {{ date('H:m', $newslo->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $newslo->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $newslo->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $newslo->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $newslo->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $newslo->leechers }}</span>
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



    <div class="tab-pane fade" id="video">
        <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">





@foreach ($video as $videos)

					@php $meta = null; @endphp
					@if ($videos->category->movie_meta)
						@if ($videos->tmdb || $videos->tmdb != 0)
							@php $meta = App\Models\Movie::where('id', '=', $videos->tmdb)->first(); @endphp
						@endif
					@endif

			<div class="gallery-item"
			@if ($videos->tmdb != 0 && $videos->tmdb != null)
			    style="background-image: url('{{ ($meta && $meta->poster) ? \tmdb_image('poster_big', $meta->poster) : '/img/poster/poster-torrent-1.png'; }}');">
            @else
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$videos->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $videos->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif
            @endif

				<div class="release-info">

				    @if ($videos->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $videos->category->id]) }}" class="release-info-quality quality-sloshare">{{ $videos->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $videos->category->id]) }}" class="release-info-quality quality-sloshare">{{ $videos->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $videos->id]) }}"title="{{ $videos->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($videos->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $videos->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $videos->comments_count }}</span></div>

						@if ($videos->category->game_meta)
						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						@endif
                        @if ($videos->tmdb != 0 && $videos->tmdb != null)
                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                        @endif

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $videos->created_at->getTimestamp()) }} | {{ date('H:m', $videos->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $videos->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $videos->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $videos->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $videos->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $videos->leechers }}</span>
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



    <div class="tab-pane fade" id="tvseries">
        <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">





@foreach ($tvserie as $tv)

					@php $meta = null; @endphp
					@if ($tv->category->tv_meta)
						@if ($tv->tmdb || $tv->tmdb != 0)
							@php $meta = App\Models\Tv::where('id', '=', $tv->tmdb)->first(); @endphp
						@endif
					@endif

			<div class="gallery-item"
			@if ($tv->tmdb != 0 && $tv->tmdb != null)
			    style="background-image: url('{{ ($meta && $meta->poster) ? \tmdb_image('poster_big', $meta->poster) : '/img/poster/poster-torrent-1.png'; }}');">
            @else
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$tv->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $tv->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif
            @endif

				<div class="release-info">

				    @if ($tv->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $tv->category->id]) }}" class="release-info-quality quality-sloshare">{{ $tv->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $tv->category->id]) }}" class="release-info-quality quality-sloshare">{{ $tv->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $tv->id]) }}"title="{{ $tv->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($tv->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $tv->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $tv->comments_count }}</span></div>

						@if ($tv->category->game_meta)
						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						@endif
                        @if ($tv->tmdb != 0 && $tv->tmdb != null)
                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                        @endif

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $tv->created_at->getTimestamp()) }} | {{ date('H:m', $tv->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $tv->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $tv->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $tv->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $tv->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $tv->leechers }}</span>
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


    <div class="tab-pane fade" id="games">
       <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">





@foreach ($game as $games)

					@php $meta = null; @endphp
					@if ($games->category->game_meta)
						@if ($games->igdb || $games->igdb != 0)
							@php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($games->igdb); @endphp
						@endif
					@endif

			<div class="gallery-item" style="background-image: url('{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/poster/poster-torrent-1.png' }}');">
				<div class="release-info">

				    @if ($games->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $games->category->id]) }}" class="release-info-quality quality-sloshare">{{ $games->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $games->category->id]) }}" class="release-info-quality quality-sloshare">{{ $games->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $games->id]) }}"title="{{ $games->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($games->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $games->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $games->comments_count }}</span></div>

						@if ($games->category->game_meta)
						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						@endif
                        @if ($games->tmdb != 0 && $games->tmdb != null)
                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                        @endif

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $games->created_at->getTimestamp()) }} | {{ date('H:m', $games->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $games->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $games->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $games->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $games->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $games->leechers }}</span>
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


    <div class="tab-pane fade" id="applications">
       <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">

@foreach ($applications as $application)

			<div class="gallery-item"
			@if ($application->category->no_meta)
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$application->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $application->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif
            @endif
				<div class="release-info">

				    @if ($application->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $application->category->id]) }}" class="release-info-quality quality-sloshare">{{ $application->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $application->category->id]) }}" class="release-info-quality quality-sloshare">{{ $application->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $application->id]) }}"title="{{ $application->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($application->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $application->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $application->comments_count }}</span></div>

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $application->created_at->getTimestamp()) }} | {{ date('H:m', $application->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $application->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $application->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $application->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $application->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $application->leechers }}</span>
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


    <div class="tab-pane fade" id="cartoons">
       <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">

@foreach ($cartoons as $cartoon)

					@php $meta = null; @endphp
					@if ($cartoon->category->movie_meta)
						@if ($cartoon->tmdb || $cartoon->tmdb != 0)
							@php $meta = App\Models\Movie::where('id', '=', $cartoon->tmdb)->first(); @endphp
						@endif
					@endif

			<div class="gallery-item"
			@if ($cartoon->tmdb != 0 && $cartoon->tmdb != null)
			    style="background-image: url('{{ ($meta && $meta->poster) ? \tmdb_image('poster_big', $meta->poster) : '/img/poster/poster-torrent-1.png'; }}');">
            @else
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$cartoon->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $cartoon->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif
            @endif




				<div class="release-info">

				    @if ($cartoon->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $cartoon->category->id]) }}" class="release-info-quality quality-sloshare">{{ $cartoon->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $cartoon->category->id]) }}" class="release-info-quality quality-sloshare">{{ $cartoon->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $cartoon->id]) }}"title="{{ $cartoon->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($cartoon->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $cartoon->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $cartoon->comments_count }}</span></div>

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $cartoon->created_at->getTimestamp()) }} | {{ date('H:m', $cartoon->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $cartoon->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $cartoon->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $cartoon->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $cartoon->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $cartoon->leechers }}</span>
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


    <div class="tab-pane fade" id="xxx">
       <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat shoutbox">
            <div id="myCarousel" class="keen-slider-slo">





@foreach ($xxx as $x)
			<div class="gallery-item"
			@if ($application->category->no_meta)
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$x->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $x->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/poster-torrent-1.png');">
            @endif
            @endif
				<div class="release-info">

				    @if ($x->free == '1' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $x->category->id]) }}" class="release-info-quality quality-sloshare">{{ $x->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $x->category->id]) }}" class="release-info-quality quality-sloshare">{{ $x->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $x->id]) }}"title="{{ $x->name }}" class="release-info-title sloshare-title">@joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($x->name), 30))...</a>
					<div class="release-info-container">
						<div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $x->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $x->comments_count }}</span></div>

						@if ($x->category->game_meta)
						<div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						@endif
                        @if ($x->category->movie_meta || $x->category->tv_meta)
                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                        @endif

						<div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $x->created_at->getTimestamp()) }} | {{ date('H:m', $x->created_at->getTimestamp()) }}</div>
						<div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $x->user->username }}</div>
					</div>
					<div class="release-info-rating">
						<a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $x->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $x->getSize() }}</a>
						<div style="float: right;">
							<span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $x->seeders }}</span>
							<span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $x->leechers }}</span>
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
