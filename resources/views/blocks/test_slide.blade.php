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

    <div class="tab-pane fade active in" id="new-sloshare">
        <div class="container">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->


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


                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">

            <div class="gallery-item"
			@if ($newslo->category->movie_meta || $newslo->category->tv_meta)
			    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_holder_400x600.jpg' }}"
			        class="show-poster" alt="{{ __('torrent.poster') }}>
            @endif

            @if ($newslo->category->game_meta && isset($meta) && $meta->cover['image_id'] && $meta->name)
                style="background-image: url('{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/poster/games_no_image_400x600.jpg' }}');')
                    class="show-poster"  alt="{{ __('torrent.poster') }}>
            @endif

            @if(file_exists(public_path().'/files/img/torrent-cover_'.$newslo->id.'.jpg'))
            style="background-image: url('{{ url('files/img/torrent-cover_' . $newslo->id . '.jpg') }}');">
            @else
            style="background-image: url('/img/poster/meta_no_image_holder_400x600.jpg');">
            @endif

			@if ($newslo->category->music_meta)
            @if(file_exists(public_path().'/files/img/torrent-cover_'.$newslo->id.'.jpg'))
                style="background-image: url('{{ url('files/img/torrent-cover_' . $newslo->id . '.jpg') }}');">
			@endif
            @endif
				<div class="release-info">

				    @if ($newslo->free == '1' || $newslo->free >= '90' || $newslo->free < '90' && $newslo->free >= '30' || $newslo->free < '30' && $newslo->free != '0' || config('other.freeleech') == '1')
					<a href="{{ route('categories.show', ['id' => $newslo->category->id]) }}" class="release-info-quality quality-sloshare">{{ $newslo->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					@else
					<a href="{{ route('categories.show', ['id' => $newslo->category->id]) }}" class="release-info-quality quality-sloshare">{{ $newslo->category->name }}</a>
                    @endif

					<a href="{{ route('torrent', ['id' => $newslo->id]) }}"title="{{ $newslo->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($newslo->name, 50))</a>
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






                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@endforeach

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
