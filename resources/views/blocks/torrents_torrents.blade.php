<div>
	<section class="panelV2 table-responsive" x-data="{ tab: 'new-sloshare'}">

    <!-- Buttons -->
        <menu class="panel__tabs">
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'new-sloshare' && 'panel__tab--active'"
                x-on:click="tab = 'new-sloshare'"
            >
                <img src="{{ url('/icon-torrent.png') }}"> {{ __('sloshare.home-newsloshare-title') }}
            </li>
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'video' && 'panel__tab--active'"
                x-on:click="tab = 'video'"
            >
                <i class="{{ config('other.font-awesome') }} fa-film"></i> {{ __('sloshare.home-movie-title') }}
            </li>
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'tvseries' && 'panel__tab--active'"
                x-on:click="tab = 'tvseries'"
            >
                <i class="{{ config('other.font-awesome') }} fa-tv-retro"></i> {{ __('sloshare.home-tvseries-title') }}
            </li>
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'games' && 'panel__tab--active'"
                x-on:click="tab = 'games'"
            >
                <i class="{{ config('other.font-awesome') }} fa-gamepad"></i> {{ __('sloshare.home-game-title') }}
            </li>
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'applications' && 'panel__tab--active'"
                x-on:click="tab = 'applications'"
            >
                <i class="{{ config('other.font-awesome') }} fa-compact-disc"></i> {{ __('sloshare.home-applications-title') }}
            </li>
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'cartoons' && 'panel__tab--active'"
                x-on:click="tab = 'cartoons'"
            >
                <i class="{{ config('other.font-awesome') }} fa-baby"></i> {{ __('sloshare.home-cartoons-title') }}
            </li>
            <li
                class="panel__tab"
                role="tab"
                x-bind:class="tab === 'xxx' && 'panel__tab--active'"
                x-on:click="tab = 'xxx'"
            >
                <i class="{{ config('other.font-awesome') }} fa-heart"></i> {{ __('sloshare.home-xxx-title') }}
            </li>
        </menu>
    <!-- Buttons -->
        <div class="tab-content" x-cloak x-show="tab === 'new-sloshare'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >
                @foreach($newsloshare as $torrent)
                    @php $meta = null @endphp
                    @if ($torrent->category->tv_meta)
                        @if ($torrent->tmdb || $torrent->tmdb != 0)
                            @php $meta = cache()->remember('tvmeta:'.$torrent->tmdb.$torrent->category_id, 3_600, fn () => App\Models\Tv::select(['id', 'poster', 'vote_average'])->where('id', '=', $torrent->tmdb)->first()) @endphp
                        @endif
                    @endif
                    @if ($torrent->category->movie_meta)
                        @if ($torrent->tmdb || $torrent->tmdb != 0)
                            @php $meta = cache()->remember('moviemeta:'.$torrent->tmdb.$torrent->category_id, 3_600, fn () => App\Models\Movie::select(['id', 'poster', 'vote_average'])->where('id', '=', $torrent->tmdb)->first()) @endphp
                        @endif
                    @endif
                    @if ($torrent->category->cartoon_meta)
                        @if ($torrent->tmdb || $torrent->tmdb != 0)
                            @php $meta = cache()->remember('cartoonmeta:'.$torrent->tmdb.$torrent->category_id, 3_600, fn () => App\Models\Cartoon::select(['id', 'poster', 'vote_average'])->where('id', '=', $torrent->tmdb)->first()) @endphp
                        @endif
                    @endif
                    @if ($torrent->category->cartoontv_meta)
                        @if ($torrent->tmdb || $torrent->tmdb != 0)
                            @php $meta = cache()->remember('tvmeta:'.$torrent->tmdb.$torrent->category_id, 3_600, fn () => App\Models\CartoonTv::select(['id', 'poster', 'vote_average'])->where('id', '=', $torrent->tmdb)->first()) @endphp
                        @endif
                    @endif
                    @if ($torrent->category->game_meta)
                        @if ($torrent->igdb || $torrent->igdb != 0)
                            @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                        @endif
                    @endif
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item"
				            @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
    							    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_400x600.jpg' }}"
    							    class="show-poster" alt={{ $torrent->name }}>
    					        @endif
                            @endif

    			            @if ($torrent->category->cartoon_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
    							    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/cartoon_no_image_400x600.jpg' }}"
    							    class="show-poster" alt={{ $torrent->name }}>
    						    @endif
                            @endif

    			            @if ($torrent->category->cartoontv_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
    							    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/cartoon_no_image_400x600.jpg' }}"
    							    class="show-poster" alt={{ $torrent->name }}>
    						    @endif
                            @endif

                            @if ($torrent->category->game_meta && isset($meta) && $meta->cover['image_id'] && $meta->name)
                                style="background-image: url('{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/SLOshare/games_no_image_400x600.jpg' }}');')
                                class="show-poster" alt={{ $torrent->name }}>
                            @endif

                            @if ($torrent->category->music_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
    						    @else
    							    style="background-image: url('/img/SLOshare/music_no_image_400x600.jpg')" class="show-poster" alt={{ $torrent->name }}>
                                @endif
                            @endif

                            @if($torrent->category->no_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
                                    style="background-image: url('/img/SLOshare/meta_no_image_400x600.jpg')" class="show-poster" alt={{ $torrent->name }}>
                                @endif
                            @endif

				            <div class="release-info">

				            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					        @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

						            @if ($torrent->category->game_meta)
						                <div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						            @endif
                                    @if ($torrent->tmdb != 0 && $torrent->tmdb != null)
                                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                                    @endif

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>

        <div class="tab-content" x-cloak x-show="tab === 'video'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >

                @foreach ($video as $torrent)
                    @php $meta = null; @endphp
				    @if ($torrent->category->movie_meta)
				        @if ($torrent->tmdb || $torrent->tmdb != 0)
					        @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first(); @endphp
				        @endif
			        @endif
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item"
				            @if ($torrent->category->movie_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt="{{ $torrent->name }}">
                                @else
    							    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_400x600.jpg' }}"
    							    class="show-poster" alt="{{ $torrent->name }}">
    					        @endif
                            @endif

				            <div class="release-info">

				            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					        @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

                                    @if ($torrent->tmdb != 0 && $torrent->tmdb != null)
                                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                                    @endif

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>

        <div class="tab-content" x-cloak x-show="tab === 'tvseries'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >

                @foreach ($tvserie as $torrent)
                    @php $meta = null; @endphp
			        @if ($torrent->category->tv_meta)
				        @if ($torrent->tmdb || $torrent->tmdb != 0)
					        @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first(); @endphp
				        @endif
			        @endif
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item"
				            @if ($torrent->category->tv_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
    							    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/movie_no_image_400x600.jpg' }}"
    							    class="show-poster" alt={{ $torrent->name }}>
    					        @endif
                            @endif

				            <div class="release-info">

				            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					        @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

                                    @if ($torrent->tmdb != 0 && $torrent->tmdb != null)
                                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                                    @endif

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>

        <div class="tab-content" x-cloak x-show="tab === 'games'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >

                @foreach ($game as $torrent)
    			    @php $meta = null; @endphp
                    @if ($torrent->category->game_meta)
				        @if ($torrent->igdb || $torrent->igdb != 0)
					        @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb); @endphp
				        @endif
			        @endif
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item" style="background-image: url('{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/poster/games_no_image_400x600.jpg' }}');"
                            alt="{{ $torrent->name }}">

				            <div class="release-info">

				            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					        @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

						            @if ($torrent->category->game_meta)
						                <div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						            @endif

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>

        <div class="tab-content" x-cloak x-show="tab === 'applications'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >

                @foreach ($applications as $torrent)
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item"
                            @if($torrent->category->no_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
                                    style="background-image: url('/img/SLOshare/meta_no_image_400x600.jpg')" class="show-poster" alt={{ $torrent->name }}>
                                @endif
                            @endif

				            <div class="release-info">

				            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					        @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

                                    @if ($torrent->tmdb != 0 && $torrent->tmdb != null)
                                        <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                                    @endif

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>

        <div class="tab-content" x-cloak x-show="tab === 'cartoons'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >

                @foreach ($cartoones as $torrent)
                    @php $meta = null; @endphp
			        @if ($torrent->category->cartoon_meta)
				        @if ($torrent->tmdb || $torrent->tmdb != 0)
					        @php $meta = App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first(); @endphp
				        @endif
                    @endif

			        @if ($torrent->category->cartoontv_meta)
				        @if ($torrent->tmdb || $torrent->tmdb != 0)
					        @php $meta = App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first(); @endphp
				        @endif
			        @endif
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item"
    			            @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
    							    style="background-image: url('{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : '/img/SLOshare/cartoon_no_image_400x600.jpg' }}"
    							    class="show-poster" alt={{ $torrent->name }}>
    						    @endif
                            @endif

				            <div class="release-info">

				            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
					        @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>

        <div class="tab-content" x-cloak x-show="tab === 'xxx'">
            <div x-data>
                <ul
                    class="featured-carousel"
                    x-ref="featured"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >

                @foreach ($xxx as $torrent)
                    <div class="item mini backdrop mini_card">
			            <div class="gallery-item"
                            @if($torrent->category->no_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    style="background-image: url('{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}');" class="show-poster" alt={{ $torrent->name }}>
                                @else
                                    style="background-image: url('/img/SLOshare/meta_no_image_400x600.jpg')" class="show-poster" alt={{ $torrent->name }}>
                                @endif
                            @endif

				            <div class="release-info">

                            @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }} <span class="FL-torrent" title="{{ __('sloshare.freeleech') }}">{{ __('sloshare.fl') }}</span></a>
                            @else
					            <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}" class="release-info-quality quality-sloshare">{{ $torrent->category->name }}</a>
                            @endif

					            <a href="{{ route('torrent', ['id' => $torrent->id]) }}"title="{{ $torrent->name }}" class="release-info-title sloshare-title">@joypixels(Str::limit($torrent->name, 50))</a>
					            <div class="release-info-container">
						            <div class="release-info-meta">{{ __('sloshare.files') }} <span class="badge-sloshare-primary">{{ $torrent->files->count() }}</span> | {{ __('sloshare.comments') }} <span class="badge-sloshare-primary">{{ $torrent->comments_count }}</span></div>

						            @if ($torrent->category->game_meta)
						                <div class="release-info-meta"><a class="badge-status">IGDB: {{ $meta->rating_count ?? 0 }}/100</a></div>
						            @endif
                                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                    <div class="release-info-meta"><a class="badge-status">TMDB: {{ $meta->vote_average ?? 0 }}/10</a></div>
                                    @endif

						            <div class="release-info-meta">{{ __('sloshare.added') }} {{ date('d.m.Y', $torrent->created_at->getTimestamp()) }} | {{ date('H:m', $torrent->created_at->getTimestamp()) }}</div>
						            <div class="release-info-meta">{{ __('sloshare.uppedby') }} {{ $torrent->user->username }}</div>
					            </div>
					            <div class="release-info-rating">
						            <a class="release-info-rating-likes download-link" href="{{ route('download', ['id' => $torrent->id]) }}" data-title-tooltip title="{{ __('sloshare.download') }}"><i class="fas fa-file-download"></i> {{ $torrent->getSize() }}</a>
						            <div style="float: right;">
							            <span title="{{ __('sloshare.seeders') }}" data-title-tooltip class="badge-sloshare-success">{{ $torrent->seeders }}</span>
							            <span title="{{ __('sloshare.leechers') }}" data-title-tooltip class="badge-sloshare-danger">{{ $torrent->leechers }}</span>
						            </div>
					            </div>
				            </div>
				            <!--<span class="torrent-new" title="" data-title-tooltip></span>-->
			            </div>
		            </div>
                @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous" x-on:click="$refs.featured.scrollLeft == 0 ? $refs.featured.scrollLeft = $refs.featured.scrollWidth : $refs.featured.scrollLeft -= (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next" x-on:click="$refs.featured.scrollLeft == ($refs.featured.scrollWidth - $refs.featured.offsetWidth) ? $refs.featured.scrollLeft = 0 : $refs.featured.scrollLeft += (($refs.featured.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>
    </section>