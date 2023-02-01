<div>
    <table class="table table-condensed table-bordered" id="top10-table">
        <thead>
        <tr>
            <th class="text-center dark-th" colspan="12">
                <span style="font-size: 16px;">Top 10 (Dan)</span>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($torrentsDay as $torrent)
            @php $meta = null @endphp
            @if ($torrent->category->tv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->movie_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoon_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoontv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->game_meta)
                @if ($torrent->igdb || $torrent->igdb != 0)
                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                @endif
            @endif


                <tr>
                    <td class="torrent-listings-poster" style="width: 1%;">
                         <div class="torrent-poster pull-left">
                                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/movie_no_image_holder_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/cartoon_no_image_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->game_meta)
                                    <img style="height: 80px;"
                                         src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/SLOshare/games_no_image_holder_90x135.jpg' }}"
                                         class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                @endif

                                @if ($torrent->category->music_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/music_no_image_holder_90x135.jpg" class="torrent-poster-img-small"
                                            alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->no_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/meta_no_image_holder_90x135.jpg"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif
                            </div>
                    </td>

                    <td class="torrent-listings-format" style="width: 5%; text-align: center;">
                        <div class="text-center">
                            <i class="{{ $torrent->category->icon }} torrent-icon"
                               style="@if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) padding-top: 1px; @else padding-top: 15px; @endif font-size: 24px;"></i>
                        </div>
                        <div class="text-center">
                            <span class="label label-success" style="font-size: 13px">
                                {{ $torrent->type->name }}
                            </span>
                        </div>
                        @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                            <div class="text-center" style="padding-top: 5px;">
                                <span class="label label-success" style="font-size: 13px">
                                    {{ $torrent->resolution->name ?? 'N/A' }}
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="torrent-listings-overview" style="vertical-align: middle;">
                        @if(auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                            <a href="{{ route('edit_form', ['id' => $torrent->id]) }}">
                                <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.edit') }}">
                                    <i class="{{ config('other.font-awesome') }} fa-pencil-alt"></i>
                                </button>
                            </a>
                        @endif
                        <a class="view-torrent torrent-listings-name" style="font-size: 16px;"
                           href="{{ route('torrent', ['id' => $torrent->id]) }}">
                            {{ $torrent->name }}
                        </a>
                        <br>
                        @if ($torrent->anon === 0)
                            <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} {{ $torrent->user->group->icon }}"></i>
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                        {{ $torrent->user->username }}
                                    </a>
                                </span>
                        @else
                            <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									{{ strtoupper(__('common.anonymous')) }}
                                @if ($user->group->is_modo || $torrent->user->username === $user->username)
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                            ({{ $torrent->user->username }})
                                        </a>
                                @endif
                                </span>
                        @endif
                        |
                        <span class='text-pink torrent-listings-thanks'>
                                    <i class="{{ config('other.font-awesome') }} fa-heartbeat"></i> {{ $torrent->thanks_count }}
                                </span>
                        |
                        <span class='badge-extra text-green torrent-listings-comments'>
									<i class="{{ config('other.font-awesome') }} fa-comment-alt-lines"></i> {{ $torrent->comments_count }}
								</span>
                        @if ($torrent->internal == 1)
                        |
                            <span class='text-bold torrent-listings-internal'>
                                    <i class='{{ config('other.font-awesome') }} fa-magic'
                                       title='{{ __('torrent.internal-release') }}'
                                       style="color: #baaf92;"></i>
                                </span>
                        @endif

                        <!--@if ($torrent->personal_release == 1)
                        |
                            <span class='badge-extra text-bold torrent-listings-personal'>
                                    <i class='{{ config('other.font-awesome') }} fa-user-plus'
                                       title='Personal Release' style="color: #865be9;"></i>
                                </span>
                        @endif-->

                        @if ($torrent->stream == 1)
                        |
                            <span class='text-bold torrent-listings-stream-optimized'>
                                    <i class='{{ config('other.font-awesome') }} fa-play text-red'
                                       title='{{ __('torrent.stream-optimized') }}'></i>
                                </span>
                        @endif

                        @if ($torrent->featured == 0)
                            @if ($torrent->doubleup == 1)
                            |
                                <span class='text-bold torrent-listings-double-upload'>
                                        <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                           title='{{ __('torrent.double-upload') }}'></i>
                                    </span>
                            @endif

                            @if (config('other.freeleech') == 1)
                            |
                                <span class='text-bold torrent-listings-global-freeleech'>
                                        <i class='{{ config('other.font-awesome') }} fa-star'
                                            title='{{ __('torrent.global-freeleech') }}'></i>
                                </span>
                            @elseif ($torrent->free >= '90')
                            |
                                <span class="text-bold torrent-listings-freeleech"
                                      title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                        </span>
                            @elseif ($torrent->free < '90' && $torrent->free >= '30')
                                <style>
                                    .star50 {
                                        position: relative;
                                    }

                                    .star50:after {
                                        content: "\f005";
                                        position: absolute;
                                        left: 0;
                                        top: 0;
                                        width: 50%;
                                        overflow: hidden;
                                        color: #FFB800;
                                    }
                                </style>
                                <span class="text-bold torrent-listings-freeleech"
                                      title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star50 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                            @elseif ($torrent->free < '30' && $torrent->free != '0')
                                <style>
                                    .star30 {
                                        position: relative;
                                    }

                                    .star30:after {
                                        content: "\f005";
                                        position: absolute;
                                        left: 0;
                                        top: 0;
                                        width: 30%;
                                        overflow: hidden;
                                        color: #FFB800;
                                    }
                                </style>
                                <span class="text-bold torrent-listings-freeleech"  data-toggle="tooltip"
                                        title='' data-original-title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                <i class="star30 {{ config('other.font-awesome') }} fa-star"></i>
                            </span>
                            @endif
                            @if ($torrent->fl_until !== null)
							|
                                <span class='text-bold torrent-listings-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-clock'
                                        title='{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech poteče.'></i>
                                </span>
                            @endif
                        @endif

                        @if ($user->freeleechTokens->where('torrent_id', $torrent->id)->first())
                            <span class='text-bold torrent-listings-freeleech-token'>
                                    <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                       title='{{ __('torrent.freeleech-token') }}'></i>
                                </span>
                        @endif

                        <!--@if ($torrent->featured == 1)
                            <span class='text-bold torrent-listings-featured'
                                  style='background-image:url(/img/sparkels.gif);'>
                                    <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                       title='{{ __('torrent.featured') }}'></i>
                                </span>
                        @endif-->

                        <!--@if ($user->group->is_freeleech == 1)
                            <span class='text-bold torrent-listings-special-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-freeleech') }}'></i>
                                </span>
                        @endif-->

                        <!--@if (config('other.doubleup') == 1)
                            <span class='text-bold torrent-listings-global-double-upload'>
                                    <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                       title='{{ __('torrent.global-double-upload') }}'></i>
                                </span>
                        @endif-->

                        <!--@if ($user->group->is_double_upload == 1)
                            <span class='text-bold torrent-listings-special-double-upload'>
									<i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-double_upload') }}'></i>
								</span>
                        @endif-->

                        <!--@if ($torrent->leechers >= 5)
                            <span class='text-bold torrent-listings-hot'>
                                    <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                       title='{{ __('common.hot') }}'></i>
                                </span>
                        @endif-->

                        <!--@if ($torrent->sticky == 1)
                            <span class='text-bold torrent-listings-sticky'>
                                    <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                       title='{{ __('torrent.sticky') }}'></i>
                                </span>
                        @endif-->

                        <!--@if ($torrent->highspeed == 1)
                            <span class='text-bold torrent-listings-high-speed'>
									<i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                       title='{{ __('common.high-speeds') }}'></i>
								</span>
                        @endif-->

                        <!--@if ($torrent->sd == 1)
                            <span class='text-bold torrent-listings-sd'>
									<i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                       title='{{ __('torrent.sd-content') }}'></i>
								</span>
                        @endif-->

                        <!--@if ($torrent->bumped_at != $torrent->created_at && $torrent->bumped_at < Illuminate\Support\Carbon::now()->addDay(2))
                            <span class='text-bold torrent-listings-bumped'>
                                    <i class='{{ config('other.font-awesome') }} fa-level-up-alt text-gold'
                                       title='{{ __('torrent.recent-bumped') }}'></i>
                                </span>
                        @endif-->
                    </td>
                    <td class="torrent-listings-download text-center" style="vertical-align: middle;">
                        @if (config('torrent.download_check_page') == 1)
                            <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                                <button class="btn btn-primary" type="button" title="{{ __('common.download') }}">
                                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                </button>
                            </a>
                        @else
                            <a href="{{ route('download', ['id' => $torrent->id]) }}">
                                <button class="btn btn-primary" type="button" title="{{ __('common.download') }}">
                                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                </button>
                            </a>
                        @endif
                        @if (config('torrent.magnet') == 1)
                            <a href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ $torrent->info_hash }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => $user->rsskey ]) }}&tr={{ route('announce', ['passkey' => $user->passkey]) }}&xl={{ $torrent->size }}">
                                <button class="btn btn-primary" type="button" title="{{ __('common.magnet') }}">
                                    <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                                </button>
                            </a>
                        @endif
                        <div>
                            @livewire('small-bookmark-button', ['torrent' => $torrent->id], key($torrent->id))
                        </div>
                    </td>
                    <td class="torrent-listings-tmdb text-center" style="vertical-align: middle;">
                        @if ($torrent->category->game_meta)
                            <span>
										<img src="{{ url('img/igdb.png') }}" alt="igdb_id" style="margin-left: -5px;"
                                             width="24px" height="24px"> {{ $torrent->igdb }}
	                                    <br>
										<span class="{{ rating_color($meta->rating ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ round($meta->rating ?? 0) }}/100 </span>
                                    </span>
                        @endif
                        @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                            <span>
	                                    <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
											<img src="{{ url('img/tmdb_small.png') }}" alt="tmdb_id"
                                                 style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->tmdb }}
	                                    </a>
	                                    <br>
										<span class="{{ rating_color($meta->vote_average ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->vote_average ?? 0 }}/10 </span>
                                    </span>
                        @endif
                    </td>
                    <td class="torrent-listings-size text-center" style="vertical-align: middle;">
                            <span>
                                {{ $torrent->getSize() }}
                            </span>
                    </td>
                    <td class="torrent-listings-seeders text-center" style="vertical-align: middle;">
                        <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-green'>
	                                    {{ $torrent->seeders }}
                                    </span>
                        </a>
                    </td>
                    <td class="torrent-listings-leechers text-center" style="vertical-align: middle;">
                        <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-red'>
	                                    {{ $torrent->leechers }}
                                    </span>
                        </a>
                    </td>
                    <td class="torrent-listings-completed" style="vertical-align: middle;">
                        <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                    <span class='text-orange'>
	                                    {{ $torrent->times_completed }}
                                    </span>
                        </a>
                    </td>
                    <td class="torrent-listings-age text-center" style="vertical-align: middle;">
							<span>
								{{ $torrent->created_at->format('d.m.Y') }}
							</span>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>

    <table class="table table-condensed table-bordered" id="top10-table">
        <thead>
        <tr>
            <th class="text-center dark-th" colspan="12">
                <span style="font-size: 16px;">Top 10 (Teden)</span>
            </th>
        </tr>
        </thead>
        <tbody>
        @if($torrentsWeek)
        @foreach($torrentsWeek as $torrent)
            @php $meta = null @endphp
            @if ($torrent->category->tv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->movie_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoon_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoontv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->game_meta)
                @if ($torrent->igdb || $torrent->igdb != 0)
                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                @endif
            @endif


            <tr>
                <td class="torrent-listings-poster" style="width: 1%;">
                    <div class="torrent-poster pull-left">
                                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/movie_no_image_holder_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/cartoon_no_image_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->game_meta)
                                    <img style="height: 80px;"
                                         src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/SLOshare/games_no_image_holder_90x135.jpg' }}"
                                         class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                @endif

                                @if ($torrent->category->music_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/music_no_image_holder_90x135.jpg" class="torrent-poster-img-small"
                                            alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->no_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/meta_no_image_holder_90x135.jpg"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif
                            </div>
                </td>

                <td class="torrent-listings-format" style="width: 5%; text-align: center;">
                    <div class="text-center">
                        <i class="{{ $torrent->category->icon }} torrent-icon"
                           style="@if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) padding-top: 1px; @else padding-top: 15px; @endif font-size: 24px;"></i>
                    </div>
                    <div class="text-center">
                        <span class="label label-success" style="font-size: 13px">
                            {{ $torrent->type->name }}
                        </span>
                    </div>
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <div class="text-center" style="padding-top: 5px;">
                                <span class="label label-success" style="font-size: 13px">
                                    {{ $torrent->resolution->name ?? 'N/A' }}
                                </span>
                        </div>
                    @endif
                </td>
                <td class="torrent-listings-overview" style="vertical-align: middle;">
                    @if(auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                        <a href="{{ route('edit_form', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.edit') }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil-alt"></i>
                            </button>
                        </a>
                    @endif
                    <a class="view-torrent torrent-listings-name" style="font-size: 16px;"
                       href="{{ route('torrent', ['id' => $torrent->id]) }}">
                        {{ $torrent->name }}
                    </a>
                    <br>
                    @if ($torrent->anon === 0)
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} {{ $torrent->user->group->icon }}"></i>
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                        {{ $torrent->user->username }}
                                    </a>
                                </span>
                    @else
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									{{ strtoupper(__('common.anonymous')) }}
                            @if ($user->group->is_modo || $torrent->user->username === $user->username)
                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                            ({{ $torrent->user->username }})
                                        </a>
                            @endif
                                </span>
                    @endif
                    |
                    <span class='text-pink torrent-listings-thanks'>
                                    <i class="{{ config('other.font-awesome') }} fa-heartbeat"></i> {{ $torrent->thanks_count }}
                                </span>
                    |
                    <span class='text-green torrent-listings-comments'>
									<i class="{{ config('other.font-awesome') }} fa-comment-alt-lines"></i> {{ $torrent->comments_count }}
								</span>
                    @if ($torrent->internal == 1)
                    |
                        <span class='text-bold torrent-listings-internal'>
                                    <i class='{{ config('other.font-awesome') }} fa-magic'
                                       title='{{ __('torrent.internal-release') }}'
                                       style="color: #baaf92;"></i>
                                </span>
                    @endif

                    <!--@if ($torrent->personal_release == 1)
                    |
                        <span class='text-bold torrent-listings-personal'>
                                    <i class='{{ config('other.font-awesome') }} fa-user-plus'
                                       title='Personal Release' style="color: #865be9;"></i>
                                </span>
                    @endif-->

                    @if ($torrent->stream == 1)
                    |
                        <span class='text-bold torrent-listings-stream-optimized'>
                                    <i class='{{ config('other.font-awesome') }} fa-play text-red'
                                       title='{{ __('torrent.stream-optimized') }}'></i>
                                </span>
                    @endif

                    @if ($torrent->featured == 0)
                        @if ($torrent->doubleup == 1)
                        |
                            <span class='text-bold torrent-listings-double-upload'>
                                        <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                           title='{{ __('torrent.double-upload') }}'></i>
                                    </span>
                        @endif

                        @if (config('other.freeleech') == 1)
                        |
                            <span class='text-bold torrent-listings-global-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-star'
                                        title='{{ __('torrent.global-freeleech') }}'></i>
                            </span>
                        @elseif ($torrent->free >= '90')
                        |
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                        </span>
                        @elseif ($torrent->free < '90' && $torrent->free >= '30')
                            <style>
                                .star50 {
                                    position: relative;
                                }

                                .star50:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 50%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star50 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                        @elseif ($torrent->free < '30' && $torrent->free != '0')
                            <style>
                                .star30 {
                                    position: relative;
                                }

                                .star30:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 30%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star30 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                            @endif
                            @if ($torrent->fl_until !== null)
							|
                                <span class='text-bold torrent-listings-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-clock'
                                        title='{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech poteče.'></i>
                                </span>
                            @endif
                        @endif

                    @if ($user->freeleechTokens->where('torrent_id', $torrent->id)->first())
                        <span class='text-bold torrent-listings-freeleech-token'>
                                    <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                       title='{{ __('torrent.freeleech-token') }}'></i>
                                </span>
                    @endif

                    <!--@if ($torrent->featured == 1)
                        <span class='text-bold torrent-listings-featured'
                              style='background-image:url(/img/sparkels.gif);'>
                                    <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                       title='{{ __('torrent.featured') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_freeleech == 1)
                        <span class='text-bold torrent-listings-special-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-freeleech') }}'></i>
                                </span>
                    @endif-->

                    <!--@if (config('other.doubleup') == 1)
                        <span class='text-bold torrent-listings-global-double-upload'>
                                    <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                       title='{{ __('torrent.global-double-upload') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_double_upload == 1)
                        <span class='text-bold torrent-listings-special-double-upload'>
									<i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-double_upload') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->leechers >= 5)
                        <span class='text-bold torrent-listings-hot'>
                                    <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                       title='{{ __('common.hot') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->sticky == 1)
                        <span class='text-bold torrent-listings-sticky'>
                                    <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                       title='{{ __('torrent.sticky') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->highspeed == 1)
                        <span class='text-bold torrent-listings-high-speed'>
									<i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                       title='{{ __('common.high-speeds') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->sd == 1)
                        <span class='text-bold torrent-listings-sd'>
									<i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                       title='{{ __('torrent.sd-content') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->bumped_at != $torrent->created_at && $torrent->bumped_at < Illuminate\Support\Carbon::now()->addDay(2))
                        <span class='text-bold torrent-listings-bumped'>
                                    <i class='{{ config('other.font-awesome') }} fa-level-up-alt text-gold'
                                       title='{{ __('torrent.recent-bumped') }}'></i>
                                </span>
                    @endif-->
                </td>
                <td class="torrent-listings-download text-center" style="vertical-align: middle;">
                    @if (config('torrent.download_check_page') == 1)
                        <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('download', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @endif
                    @if (config('torrent.magnet') == 1)
                        <a href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ $torrent->info_hash }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => $user->rsskey ]) }}&tr={{ route('announce', ['passkey' => $user->passkey]) }}&xl={{ $torrent->size }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.magnet') }}">
                                <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                            </button>
                        </a>
                    @endif
                    <div>
                        @livewire('small-bookmark-button', ['torrent' => $torrent->id], key($torrent->id))
                    </div>
                </td>
                <td class="torrent-listings-tmdb text-center" style="vertical-align: middle;">
                    @if ($torrent->category->game_meta)
                        <span>
										<img src="{{ url('img/igdb.png') }}" alt="igdb_id" style="margin-left: -5px;"
                                             width="24px" height="24px"> {{ $torrent->igdb }}
	                                    <br>
										<span class="{{ rating_color($meta->rating ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ round($meta->rating ?? 0) }}/100 </span>
                                    </span>
                    @endif
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <span>
	                                    <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
											<img src="{{ url('img/tmdb_small.png') }}" alt="tmdb_id"
                                                 style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->tmdb }}
	                                    </a>
	                                    <br>
										<span class="{{ rating_color($meta->vote_average ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->vote_average ?? 0 }}/10 </span>
                                    </span>
                    @endif
                </td>
                <td class="torrent-listings-size text-center" style="vertical-align: middle;">
                            <span>
                                {{ $torrent->getSize() }}
                            </span>
                </td>
                <td class="torrent-listings-seeders text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-green'>
	                                    {{ $torrent->seeders }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-leechers text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-red'>
	                                    {{ $torrent->leechers }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-completed text-center" style="vertical-align: middle;">
                    <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                    <span class='text-orange'>
	                                    {{ $torrent->times_completed }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-agetext-center" style="vertical-align: middle;">
							<span>
								{{ $torrent->created_at->format('d.m.Y') }}
							</span>
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

    <table class="table table-condensed table-bordered" id="top10-table">
        <thead>
        <tr>
            <th class="text-center dark-th" colspan="12">
                <span style="font-size: 16px;">Top 10 (Mesec)</span>
            </th>
        </tr>
        </thead>
        <tbody>
        @if($torrentsMonth)
        @foreach($torrentsMonth as $torrent)
            @php $meta = null @endphp
            @if ($torrent->category->tv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->movie_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoon_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoontv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->game_meta)
                @if ($torrent->igdb || $torrent->igdb != 0)
                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                @endif
            @endif


            <tr>
                <td class="torrent-listings-poster" style="width: 1%;">
                    <div class="torrent-poster pull-left">
                                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/movie_no_image_holder_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/cartoon_no_image_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->game_meta)
                                    <img style="height: 80px;"
                                         src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/SLOshare/games_no_image_holder_90x135.jpg' }}"
                                         class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                @endif

                                @if ($torrent->category->music_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/music_no_image_holder_90x135.jpg" class="torrent-poster-img-small"
                                            alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->no_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/meta_no_image_holder_90x135.jpg"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif
                            </div>
                </td>

                <td class="torrent-listings-format" style="width: 5%; text-align: center;">
                    <div class="text-center">
                        <i class="{{ $torrent->category->icon }} torrent-icon"
                           style="@if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) padding-top: 1px; @else padding-top: 15px; @endif font-size: 24px;"></i>
                    </div>
                    <div class="text-center">
                        <span class="label label-success" style="font-size: 13px">
                            {{ $torrent->type->name }}
                        </span>
                    </div>
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <div class="text-center" style="padding-top: 5px;">
                                <span class="label label-success" style="font-size: 13px">
                                    {{ $torrent->resolution->name ?? 'N/A' }}
                                </span>
                        </div>
                    @endif
                </td>
                <td class="torrent-listings-overview" style="vertical-align: middle;">
                    @if(auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                        <a href="{{ route('edit_form', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.edit') }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil-alt"></i>
                            </button>
                        </a>
                    @endif
                    <a class="view-torrent torrent-listings-name" style="font-size: 16px;"
                       href="{{ route('torrent', ['id' => $torrent->id]) }}">
                        {{ $torrent->name }}
                    </a>
                    <br>
                    @if ($torrent->anon === 0)
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} {{ $torrent->user->group->icon }}"></i>
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                        {{ $torrent->user->username }}
                                    </a>
                                </span>
                    @else
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									{{ strtoupper(__('common.anonymous')) }}
                            @if ($user->group->is_modo || $torrent->user->username === $user->username)
                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                            ({{ $torrent->user->username }})
                                        </a>
                            @endif
                                </span>
                    @endif
                    |
                    <span class='text-pink torrent-listings-thanks'>
                                    <i class="{{ config('other.font-awesome') }} fa-heartbeat"></i> {{ $torrent->thanks_count }}
                                </span>
                    |
                    <span class='text-green torrent-listings-comments'>
									<i class="{{ config('other.font-awesome') }} fa-comment-alt-lines"></i> {{ $torrent->comments_count }}
								</span>
                    @if ($torrent->internal == 1)
                    |
                        <span class='text-bold torrent-listings-internal'>
                                    <i class='{{ config('other.font-awesome') }} fa-magic'
                                       title='{{ __('torrent.internal-release') }}'
                                       style="color: #baaf92;"></i>
                                </span>
                    @endif

                    <!--@if ($torrent->personal_release == 1)
                    |
                        <span class='text-bold torrent-listings-personal'>
                                    <i class='{{ config('other.font-awesome') }} fa-user-plus'
                                       title='Personal Release' style="color: #865be9;"></i>
                                </span>
                    @endif-->

                    @if ($torrent->stream == 1)
                    |
                        <span class='text-bold torrent-listings-stream-optimized'>
                                    <i class='{{ config('other.font-awesome') }} fa-play text-red'
                                       title='{{ __('torrent.stream-optimized') }}'></i>
                                </span>
                    @endif

                    @if ($torrent->featured == 0)
                        @if ($torrent->doubleup == 1)
                        |
                            <span class='text-bold torrent-listings-double-upload'>
                                        <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                           title='{{ __('torrent.double-upload') }}'></i>
                                    </span>
                        @endif

                        @if (config('other.freeleech') == 1)
                        |
                            <span class='text-bold torrent-listings-global-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-star'
                                        title='{{ __('torrent.global-freeleech') }}'></i>
                            </span>
                        @elseif ($torrent->free >= '90')
                        |
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                        </span>
                        @elseif ($torrent->free < '90' && $torrent->free >= '30')
                            <style>
                                .star50 {
                                    position: relative;
                                }

                                .star50:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 50%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star50 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                        @elseif ($torrent->free < '30' && $torrent->free != '0')
                            <style>
                                .star30 {
                                    position: relative;
                                }

                                .star30:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 30%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star30 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                            @endif
                            @if ($torrent->fl_until !== null)
							|
                                <span class='text-bold torrent-listings-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-clock'
                                        title='{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech poteče.'></i>
                                </span>
                            @endif
                        @endif

                    @if ($user->freeleechTokens->where('torrent_id', $torrent->id)->first())
                        <span class='text-bold torrent-listings-freeleech-token'>
                                    <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                       title='{{ __('torrent.freeleech-token') }}'></i>
                                </span>
                    @endif

                    <!--@if ($torrent->featured == 1)
                        <span class='text-bold torrent-listings-featured'
                              style='background-image:url(/img/sparkels.gif);'>
                                    <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                       title='{{ __('torrent.featured') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_freeleech == 1)
                        <span class='text-bold torrent-listings-special-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-freeleech') }}'></i>
                                </span>
                    @endif-->

                    <!--@if (config('other.doubleup') == 1)
                        <span class='text-bold torrent-listings-global-double-upload'>
                                    <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                       title='{{ __('torrent.global-double-upload') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_double_upload == 1)
                        <span class='text-bold torrent-listings-special-double-upload'>
									<i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-double_upload') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->leechers >= 5)
                        <span class='text-bold torrent-listings-hot'>
                                    <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                       title='{{ __('common.hot') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->sticky == 1)
                        <span class='text-bold torrent-listings-sticky'>
                                    <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                       title='{{ __('torrent.sticky') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->highspeed == 1)
                        <span class='text-bold torrent-listings-high-speed'>
									<i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                       title='{{ __('common.high-speeds') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->sd == 1)
                        <span class='text-bold torrent-listings-sd'>
									<i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                       title='{{ __('torrent.sd-content') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->bumped_at != $torrent->created_at && $torrent->bumped_at < Illuminate\Support\Carbon::now()->addDay(2))
                        <span class='text-bold torrent-listings-bumped'>
                                    <i class='{{ config('other.font-awesome') }} fa-level-up-alt text-gold'
                                       title='{{ __('torrent.recent-bumped') }}'></i>
                                </span>
                    @endif-->
                </td>
                <td class="torrent-listings-download text-center" style="vertical-align: middle;">
                    @if (config('torrent.download_check_page') == 1)
                        <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('download', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @endif
                    @if (config('torrent.magnet') == 1)
                        <a href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ $torrent->info_hash }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => $user->rsskey ]) }}&tr={{ route('announce', ['passkey' => $user->passkey]) }}&xl={{ $torrent->size }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.magnet') }}">
                                <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                            </button>
                        </a>
                    @endif
                    <div>
                        @livewire('small-bookmark-button', ['torrent' => $torrent->id], key($torrent->id))
                    </div>
                </td>
                <td class="torrent-listings-tmdb text-center" style="vertical-align: middle;">
                    @if ($torrent->category->game_meta)
                        <span>
										<img src="{{ url('img/igdb.png') }}" alt="igdb_id" style="margin-left: -5px;"
                                             width="24px" height="24px"> {{ $torrent->igdb }}
	                                    <br>
										<span class="{{ rating_color($meta->rating ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ round($meta->rating ?? 0) }}/100 </span>
                                    </span>
                    @endif
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <span>
	                                    <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
											<img src="{{ url('img/tmdb_small.png') }}" alt="tmdb_id"
                                                 style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->tmdb }}
	                                    </a>
	                                    <br>
										<span class="{{ rating_color($meta->vote_average ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->vote_average ?? 0 }}/10 </span>
                                    </span>
                    @endif
                </td>
                <td class="torrent-listings-size text-center" style="vertical-align: middle;">
                            <span>
                                {{ $torrent->getSize() }}
                            </span>
                </td>
                <td class="torrent-listings-seeders text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-green'>
	                                    {{ $torrent->seeders }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-leechers text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-red'>
	                                    {{ $torrent->leechers }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-completed text-center" style="vertical-align: middle;">
                    <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                    <span class='text-orange'>
	                                    {{ $torrent->times_completed }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-agetext-center" style="vertical-align: middle;">
							<span>
								{{ $torrent->created_at->format('d.m.Y') }}
							</span>
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

    <table class="table table-condensed table-bordered" id="top10-table">
        <thead>
        <tr>
            <th class="text-center dark-th" colspan="12">
                <span style="font-size: 16px;">Top 10 (Leto)</span>
            </th>
        </tr>
        </thead>
        <tbody>
        @if($torrentsYear)
        @foreach($torrentsYear as $torrent)
            @php $meta = null @endphp
            @if ($torrent->category->tv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->movie_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoon_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoontv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->game_meta)
                @if ($torrent->igdb || $torrent->igdb != 0)
                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                @endif
            @endif


            <tr>
                <td class="torrent-listings-poster" style="width: 1%;">
                    <div class="torrent-poster pull-left">
                                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/movie_no_image_holder_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/cartoon_no_image_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->game_meta)
                                    <img style="height: 80px;"
                                         src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/SLOshare/games_no_image_holder_90x135.jpg' }}"
                                         class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                @endif

                                @if ($torrent->category->music_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/music_no_image_holder_90x135.jpg" class="torrent-poster-img-small"
                                            alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->no_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/meta_no_image_holder_90x135.jpg"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif
                            </div>
                </td>

                <td class="torrent-listings-format" style="width: 5%; text-align: center;">
                    <div class="text-center">
                        <i class="{{ $torrent->category->icon }} torrent-icon"
                           style="@if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) padding-top: 1px; @else padding-top: 15px; @endif font-size: 24px;"></i>
                    </div>
                    <div class="text-center">
                        <span class="label label-success" style="font-size: 13px">
                            {{ $torrent->type->name }}
                        </span>
                    </div>
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <div class="text-center" style="padding-top: 5px;">
                                <span class="label label-success" style="font-size: 13px">
                                    {{ $torrent->resolution->name ?? 'N/A' }}
                                </span>
                        </div>
                    @endif
                </td>
                <td class="torrent-listings-overview" style="vertical-align: middle;">
                    @if(auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                        <a href="{{ route('edit_form', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.edit') }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil-alt"></i>
                            </button>
                        </a>
                    @endif
                    <a class="view-torrent torrent-listings-name" style="font-size: 16px;"
                       href="{{ route('torrent', ['id' => $torrent->id]) }}">
                        {{ $torrent->name }}
                    </a>
                    <br>
                    @if ($torrent->anon === 0)
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} {{ $torrent->user->group->icon }}"></i>
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                        {{ $torrent->user->username }}
                                    </a>
                                </span>
                    @else
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									{{ strtoupper(__('common.anonymous')) }}
                            @if ($user->group->is_modo || $torrent->user->username === $user->username)
                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                            ({{ $torrent->user->username }})
                                        </a>
                            @endif
                                </span>
                    @endif
                    |
                    <span class='text-pink torrent-listings-thanks'>
                                    <i class="{{ config('other.font-awesome') }} fa-heartbeat"></i> {{ $torrent->thanks_count }}
                                </span>
                    |
                    <span class='text-green torrent-listings-comments'>
									<i class="{{ config('other.font-awesome') }} fa-comment-alt-lines"></i> {{ $torrent->comments_count }}
								</span>
                    @if ($torrent->internal == 1)
                    |
                        <span class='text-bold torrent-listings-internal'>
                                    <i class='{{ config('other.font-awesome') }} fa-magic'
                                       title='{{ __('torrent.internal-release') }}'
                                       style="color: #baaf92;"></i>
                                </span>
                    @endif

                    <!--@if ($torrent->personal_release == 1)
                    |
                        <span class='text-bold torrent-listings-personal'>
                                    <i class='{{ config('other.font-awesome') }} fa-user-plus'
                                       title='Personal Release' style="color: #865be9;"></i>
                                </span>
                    @endif-->

                    @if ($torrent->stream == 1)
                    |
                        <span class='text-bold torrent-listings-stream-optimized'>
                                    <i class='{{ config('other.font-awesome') }} fa-play text-red'
                                       title='{{ __('torrent.stream-optimized') }}'></i>
                                </span>
                    @endif

                    @if ($torrent->featured == 0)
                        @if ($torrent->doubleup == 1)
                        |
                            <span class='text-bold torrent-listings-double-upload'>
                                        <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                           title='{{ __('torrent.double-upload') }}'></i>
                                    </span>
                        @endif

                        @if (config('other.freeleech') == 1)
                        |
                            <span class='text-bold torrent-listings-global-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-star'
                                        title='{{ __('torrent.global-freeleech') }}'></i>
                            </span>
                        @elseif ($torrent->free >= '90')
                        |
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                        </span>
                        @elseif ($torrent->free < '90' && $torrent->free >= '30')
                            <style>
                                .star50 {
                                    position: relative;
                                }

                                .star50:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 50%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star50 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                        @elseif ($torrent->free < '30' && $torrent->free != '0')
                            <style>
                                .star30 {
                                    position: relative;
                                }

                                .star30:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 30%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star30 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                            @endif
                            @if ($torrent->fl_until !== null)
							|
                                <span class='text-bold torrent-listings-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-clock'
                                        title='{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech poteče.'></i>
                                </span>
                            @endif
                        @endif

                    @if ($user->freeleechTokens->where('torrent_id', $torrent->id)->first())
                        <span class='text-bold torrent-listings-freeleech-token'>
                                    <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                       title='{{ __('torrent.freeleech-token') }}'></i>
                                </span>
                    @endif

                    <!--@if ($torrent->featured == 1)
                        <span class='text-bold torrent-listings-featured'
                              style='background-image:url(/img/sparkels.gif);'>
                                    <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                       title='{{ __('torrent.featured') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_freeleech == 1)
                        <span class='text-bold torrent-listings-special-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-freeleech') }}'></i>
                                </span>
                    @endif-->

                    <!--@if (config('other.doubleup') == 1)
                        <span class='text-bold torrent-listings-global-double-upload'>
                                    <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                       title='{{ __('torrent.global-double-upload') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_double_upload == 1)
                        <span class='text-bold torrent-listings-special-double-upload'>
									<i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-double_upload') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->leechers >= 5)
                        <span class='text-bold torrent-listings-hot'>
                                    <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                       title='{{ __('common.hot') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->sticky == 1)
                        <span class='text-bold torrent-listings-sticky'>
                                    <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                       title='{{ __('torrent.sticky') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->highspeed == 1)
                        <span class='text-bold torrent-listings-high-speed'>
									<i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                       title='{{ __('common.high-speeds') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->sd == 1)
                        <span class='text-bold torrent-listings-sd'>
									<i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                       title='{{ __('torrent.sd-content') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->bumped_at != $torrent->created_at && $torrent->bumped_at < Illuminate\Support\Carbon::now()->addDay(2))
                        <span class='text-bold torrent-listings-bumped'>
                                    <i class='{{ config('other.font-awesome') }} fa-level-up-alt text-gold'
                                       title='{{ __('torrent.recent-bumped') }}'></i>
                                </span>
                    @endif-->
                </td>
                <td class="torrent-listings-download text-center" style="vertical-align: middle;">
                    @if (config('torrent.download_check_page') == 1)
                        <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('download', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @endif
                    @if (config('torrent.magnet') == 1)
                        <a href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ $torrent->info_hash }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => $user->rsskey ]) }}&tr={{ route('announce', ['passkey' => $user->passkey]) }}&xl={{ $torrent->size }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.magnet') }}">
                                <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                            </button>
                        </a>
                    @endif
                    <div>
                        @livewire('small-bookmark-button', ['torrent' => $torrent->id], key($torrent->id))
                    </div>
                </td>
                <td class="torrent-listings-tmdb text-center" style="vertical-align: middle;">
                    @if ($torrent->category->game_meta)
                        <span>
										<img src="{{ url('img/igdb.png') }}" alt="igdb_id" style="margin-left: -5px;"
                                             width="24px" height="24px"> {{ $torrent->igdb }}
	                                    <br>
										<span class="{{ rating_color($meta->rating ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ round($meta->rating ?? 0) }}/100 </span>
                                    </span>
                    @endif
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <span>
	                                    <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
											<img src="{{ url('img/tmdb_small.png') }}" alt="tmdb_id"
                                                 style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->tmdb }}
	                                    </a>
	                                    <br>
										<span class="{{ rating_color($meta->vote_average ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->vote_average ?? 0 }}/10 </span>
                                    </span>
                    @endif
                </td>
                <td class="torrent-listings-size text-center" style="vertical-align: middle;">
                            <span>
                                {{ $torrent->getSize() }}
                            </span>
                </td>
                <td class="torrent-listings-seeders text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-green'>
	                                    {{ $torrent->seeders }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-leechers text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-red'>
	                                    {{ $torrent->leechers }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-completed text-center" style="vertical-align: middle;">
                    <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                    <span class='text-orange'>
	                                    {{ $torrent->times_completed }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-agetext-center" style="vertical-align: middle;">
							<span>
								{{ $torrent->created_at->format('d.m.Y') }}
							</span>
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

    <table class="table table-condensed table-bordered" id="top10-table">
        <thead>
        <tr>
            <th class="text-center dark-th" colspan="12">
                <span style="font-size: 16px;">Top 10 (Ves Čas)</span>
            </th>
        </tr>
        </thead>
        <tbody>
        @if($torrentsAll)
        @foreach($torrentsAll as $torrent)
            @php $meta = null @endphp
            @if ($torrent->category->tv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->movie_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoon_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->cartoontv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php $meta = App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($torrent->category->game_meta)
                @if ($torrent->igdb || $torrent->igdb != 0)
                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                @endif
            @endif


            <tr>
                <td class="torrent-listings-poster" style="width: 1%;">
                    <div class="torrent-poster pull-left">
                                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/movie_no_image_holder_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/cartoon_no_image_90x135.jpg' }}"
                                            class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->game_meta)
                                    <img style="height: 80px;"
                                         src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/SLOshare/games_no_image_holder_90x135.jpg' }}"
                                         class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                @endif

                                @if ($torrent->category->music_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/music_no_image_holder_90x135.jpg" class="torrent-poster-img-small"
                                            alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif

                                @if ($torrent->category->no_meta)
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                        <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @else
                                        <img src="/img/SLOshare/meta_no_image_holder_90x135.jpg"
                                             class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
                                    @endif
                                @endif
                            </div>
                </td>

                <td class="torrent-listings-format" style="width: 5%; text-align: center;">
                    <div class="text-center">
                        <i class="{{ $torrent->category->icon }} torrent-icon"
                           style="@if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) padding-top: 1px; @else padding-top: 15px; @endif font-size: 24px;"></i>
                    </div>
                    <div class="text-center">
                        <span class="label label-success" style="font-size: 13px">
                            {{ $torrent->type->name }}
                        </span>
                    </div>
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <div class="text-center" style="padding-top: 5px;">
                                <span class="label label-success" style="font-size: 13px">
                                    {{ $torrent->resolution->name ?? 'N/A' }}
                                </span>
                        </div>
                    @endif
                </td>
                <td class="torrent-listings-overview" style="vertical-align: middle;">
                    @if(auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                        <a href="{{ route('edit_form', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.edit') }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil-alt"></i>
                            </button>
                        </a>
                    @endif
                    <a class="view-torrent torrent-listings-name" style="font-size: 16px;"
                       href="{{ route('torrent', ['id' => $torrent->id]) }}">
                        {{ $torrent->name }}
                    </a>
                    <br>
                    @if ($torrent->anon === 0)
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} {{ $torrent->user->group->icon }}"></i>
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                        {{ $torrent->user->username }}
                                    </a>
                                </span>
                    @else
                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									{{ strtoupper(__('common.anonymous')) }}
                            @if ($user->group->is_modo || $torrent->user->username === $user->username)
                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                            ({{ $torrent->user->username }})
                                        </a>
                            @endif
                                </span>
                    @endif
                    |
                    <span class='text-pink torrent-listings-thanks'>
                                    <i class="{{ config('other.font-awesome') }} fa-heartbeat"></i> {{ $torrent->thanks_count }}
                                </span>
                    |
                    <span class='text-green torrent-listings-comments'>
									<i class="{{ config('other.font-awesome') }} fa-comment-alt-lines"></i> {{ $torrent->comments_count }}
								</span>
                    @if ($torrent->internal == 1)
                    |
                        <span class='text-bold torrent-listings-internal'>
                                    <i class='{{ config('other.font-awesome') }} fa-magic'
                                       title='{{ __('torrent.internal-release') }}'
                                       style="color: #baaf92;"></i>
                                </span>
                    @endif

                    <!--@if ($torrent->personal_release == 1)
                    |
                        <span class='text-bold torrent-listings-personal'>
                                    <i class='{{ config('other.font-awesome') }} fa-user-plus'
                                       title='Personal Release' style="color: #865be9;"></i>
                                </span>
                    @endif-->

                    @if ($torrent->stream == 1)
                    |
                        <span class='text-bold torrent-listings-stream-optimized'>
                                    <i class='{{ config('other.font-awesome') }} fa-play text-red'
                                       title='{{ __('torrent.stream-optimized') }}'></i>
                                </span>
                    @endif

                    @if ($torrent->featured == 0)
                        @if ($torrent->doubleup == 1)
                        |
                            <span class='text-bold torrent-listings-double-upload'>
                                        <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                           title='{{ __('torrent.double-upload') }}'></i>
                                    </span>
                        @endif

                        @if (config('other.freeleech') == 1)
                        |
                            <span class='text-bold torrent-listings-global-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-star'
                                        title='{{ __('torrent.global-freeleech') }}'></i>
                            </span>
                        @elseif ($torrent->free >= '90')
                        |
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                        </span>
                        @elseif ($torrent->free < '90' && $torrent->free >= '30')
                            <style>
                                .star50 {
                                    position: relative;
                                }

                                .star50:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 50%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star50 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                        @elseif ($torrent->free < '30' && $torrent->free != '0')
                            <style>
                                .star30 {
                                    position: relative;
                                }

                                .star30:after {
                                    content: "\f005";
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 30%;
                                    overflow: hidden;
                                    color: #FFB800;
                                }
                            </style>
                            <span class="text-bold torrent-listings-freeleech" title='{{ $torrent->free }}% {{ __('common.free') }}'>
                                            <i class="star30 {{ config('other.font-awesome') }} fa-star"></i>
                                        </span>
                            @endif
                            @if ($torrent->fl_until !== null)
							|
                                <span class='text-bold torrent-listings-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-clock'
                                        title='{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech poteče.'></i>
                                </span>
                            @endif
                        @endif

                    @if ($user->freeleechTokens->where('torrent_id', $torrent->id)->first())
                        <span class='text-bold torrent-listings-freeleech-token'>
                                    <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                       title='{{ __('torrent.freeleech-token') }}'></i>
                                </span>
                    @endif

                    <!--@if ($torrent->featured == 1)
                        <span class='text-bold torrent-listings-featured'
                              style='background-image:url(/img/sparkels.gif);'>
                                    <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                       title='{{ __('torrent.featured') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_freeleech == 1)
                        <span class='text-bold torrent-listings-special-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-freeleech') }}'></i>
                                </span>
                    @endif-->

                    <!--@if (config('other.doubleup') == 1)
                        <span class='text-bold torrent-listings-global-double-upload'>
                                    <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                       title='{{ __('torrent.global-double-upload') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($user->group->is_double_upload == 1)
                        <span class='text-bold torrent-listings-special-double-upload'>
									<i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       title='{{ __('torrent.special-double_upload') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->leechers >= 5)
                        <span class='text-bold torrent-listings-hot'>
                                    <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                       title='{{ __('common.hot') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->sticky == 1)
                        <span class='text-bold torrent-listings-sticky'>
                                    <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                       title='{{ __('torrent.sticky') }}'></i>
                                </span>
                    @endif-->

                    <!--@if ($torrent->highspeed == 1)
                        <span class='text-bold torrent-listings-high-speed'>
									<i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                       title='{{ __('common.high-speeds') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->sd == 1)
                        <span class='text-bold torrent-listings-sd'>
									<i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                       title='{{ __('torrent.sd-content') }}'></i>
								</span>
                    @endif-->

                    <!--@if ($torrent->bumped_at != $torrent->created_at && $torrent->bumped_at < Illuminate\Support\Carbon::now()->addDay(2))
                        <span class='text-bold torrent-listings-bumped'>
                                    <i class='{{ config('other.font-awesome') }} fa-level-up-alt text-gold'
                                       title='{{ __('torrent.recent-bumped') }}'></i>
                                </span>
                    @endif-->
                </td>
                <td class="torrent-listings-download text-center" style="vertical-align: middle;">
                    @if (config('torrent.download_check_page') == 1)
                        <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @else
                        <a href="{{ route('download', ['id' => $torrent->id]) }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.download') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                            </button>
                        </a>
                    @endif
                    @if (config('torrent.magnet') == 1)
                        <a href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ $torrent->info_hash }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => $user->rsskey ]) }}&tr={{ route('announce', ['passkey' => $user->passkey]) }}&xl={{ $torrent->size }}">
                            <button class="btn btn-primary btn-circle" type="button" title="{{ __('common.magnet') }}">
                                <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                            </button>
                        </a>
                    @endif
                    <div>
                        @livewire('small-bookmark-button', ['torrent' => $torrent->id], key($torrent->id))
                    </div>
                </td>
                <td class="torrent-listings-tmdb text-center" style="vertical-align: middle;">
                    @if ($torrent->category->game_meta)
                        <span>
										<img src="{{ url('img/igdb.png') }}" alt="igdb_id" style="margin-left: -5px;"
                                             width="24px" height="24px"> {{ $torrent->igdb }}
	                                    <br>
										<span class="{{ rating_color($meta->rating ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ round($meta->rating ?? 0) }}/100 </span>
                                    </span>
                    @endif
                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
                        <span>
	                                    <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
											<img src="{{ url('img/tmdb_small.png') }}" alt="tmdb_id"
                                                 style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->tmdb }}
	                                    </a>
	                                    <br>
										<span class="{{ rating_color($meta->vote_average ?? 'text-white') }}"><i
                                                    class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->vote_average ?? 0 }}/10 </span>
                                    </span>
                    @endif
                </td>
                <td class="torrent-listings-size text-center" style="vertical-align: middle;">
                            <span>
                                {{ $torrent->getSize() }}
                            </span>
                </td>
                <td class="torrent-listings-seeders text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-green'>
	                                    {{ $torrent->seeders }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-leechers text-center" style="vertical-align: middle;">
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    <span class='text-red'>
	                                    {{ $torrent->leechers }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-completed text-center" style="vertical-align: middle;">
                    <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                    <span class='text-orange'>
	                                    {{ $torrent->times_completed }}
                                    </span>
                    </a>
                </td>
                <td class="torrent-listings-agetext-center" style="vertical-align: middle;">
							<span>
								{{ $torrent->created_at->format('d.m.Y') }}
							</span>
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
</div>

