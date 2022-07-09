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
        <div class="container">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
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
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Olympus Photo Camera </a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(4,585 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 495.00 (17% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/fCrZot6.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Coca Cola Bottle</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(245 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 99.00 (21% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/kTmJp8W.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Jewel from Italy</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(345 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 999.00 (33% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/sMwmKmh.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">White Pepper</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(45 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 199.00 (37% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/RuPhz54.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Belt Improted From Japan</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(2,125 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 49.00 (40% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/e4ARfEJ.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Tomato</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(5 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 9.00
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/ZlchtwK.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Tape Line</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(215 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 39.00 (15% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/GRPrGN6.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Test Glasses For Lab</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i>
                                            <a href="#">(10,345 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 11,999.00 (37% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/Ds5mtGy.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Jewel From India</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(945 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 299.00 (54% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/e7IYyso.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Red Pepper</a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(15 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 5.00 (11% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/vuRE1W6.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Pro Cell Batteries </a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(745 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 19.00 (63% off)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <div class="tcb-product-item">
                                    <div class="tcb-product-photo">
                                        <a href="#"><img src="https://i.imgur.com/UibcRla.jpg" class="img-responsive" alt="a" /></a>
                                    </div>
                                    <div class="tcb-product-info">
                                        <div class="tcb-product-title">
                                            <h4><a href="#">Eye Glasses </a></h4></div>
                                        <div class="tcb-product-rating">
                                            <i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="active glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                                            <a href="#">(145 ratings)</a>
                                        </div>
                                        <div class="tcb-hline"></div>
                                        <div class="tcb-product-price">
                                            $ 129.00 (29% off)
                                        </div>
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
