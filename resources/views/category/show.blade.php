@extends('layout.default')

@section('title')
    <title>{{ $category->name }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $category->name }}">
@endsection
@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a class="breadcrumb__link" href="{{ route('torrents') }}">
            {{ __('torrent.torrents') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a class="breadcrumb__link" href="{{ route('categories.index') }}">
            {{ __('torrent.categories') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a class="breadcrumb__link" href="{{ route('categories.show', ['id' => $category->id]) }}">
            {{ $category->name }}
        </a>
    </li>
@endsection

@section('nav-tabs')
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('torrents') }}">
            Seznam
        </a>
    </li>
    <li class="nav-tab--active">
        <a class="nav-tab--active__link" href="{{ route('cards') }}">
            Kartice
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('categories.index') }}">
            Kategorije
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('grouped') }}">
            Skupine
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('top10.index') }}">
            Top 10
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('rss.index') }}">
            {{ __('rss.rss') }}
        </a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="block">
            <div class="header gradient green">
                <div class="inner_content">
                    <h1>{{ $category->name }} {{ __('torrent.torrents') }}</h1>
                </div>
            </div>
            <div class="table-responsive cat-torrents" type="list">
                <div class="text-center">
                    {{ $torrents->links() }}
                </div>
                <table class="table table-condensed table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="torrent-listings-poster"></th>
                            <th class="torrent-listings-format"></th>
                            <th class="torrents-filename torrent-listings-overview">
                                {{ __('common.name') }}
                            </th>
                            <th class="torrent-listings-download">
                                <div>
                                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                </div>
                            </th>
                            <th class="torrent-listings-tmdb">
                                <div>
                                    <i class="{{ config('other.font-awesome') }} fa-id-badge"></i>
                                </div>
                            </th>
                            <th class="torrent-listings-size">
                                <i class="{{ config('other.font-awesome') }} fa-database"></i>
                            </th>
                            <th class="torrent-listings-seeders">
                                <i class="{{ config('other.font-awesome') }} fa-arrow-alt-circle-up"></i>
                            </th>
                            <th class="torrent-listings-leechers">
                                <i class="{{ config('other.font-awesome') }} fa-arrow-alt-circle-down"></i>
                            </th>
                            <th class="torrent-listings-completed">
                                <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                            </th>
                            <th class="torrent-listings-age">
                                {{ __('common.created_at') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($torrents as $torrent)
                        @php $meta = null; @endphp
                        @if ($torrent->category->tv_meta)
                            @if ($torrent->tmdb || $torrent->tmdb != 0)
                                @php $meta = App\Models\Tv::where('id', '=', $torrent->tmdb)->first(); @endphp
                            @endif
                        @endif
                        @if ($torrent->category->movie_meta)
                            @if ($torrent->tmdb || $torrent->tmdb != 0)
                                @php $meta = App\Models\Movie::where('id', '=', $torrent->tmdb)->first(); @endphp
                            @endif
                        @endif
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
                        @if ($torrent->category->game_meta)
                            @if ($torrent->igdb || $torrent->igdb != 0)
                                @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb); @endphp
                            @endif
                        @endif

                        @if ($torrent->sticky == 1)
                            <tr class="success">
                        @else
                            <tr>
                                @endif
							<td class="torrent-listings-poster" style="width: 1%;">

									<div class="torrent-poster pull-left">
										@if ($torrent->tmdb != 0 && $torrent->tmdb != null)
											<img src="{{ isset($meta->poster) ? \tmdb_image('poster_small', $meta->poster) : '/img/poster/poster-torrent-1.png' }}"
											     class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
										@else
										    @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                                <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}" class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
											@endif
										@endif

										@if ($torrent->category->game_meta)
											<img style="height: 80px;" src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/poster/poster-torrent-1.png' }}"
											     class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
										@endif

									</div>
                                <td class="torrent-listings-format" style="width: 5%; text-align: center;">
                                    <a href="{{ route('categories.show', ['id' => $torrent->category->id]) }}">
                                        <div class="text-center">
                                            <i class="{{ $torrent->category->icon }} torrent-icon" style="@if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta) padding-top: 1px; @else padding-top: 15px; @endif font-size: 24px;"></i>
                                        </div>
                                    </a>
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
                                    <a class="view-torrent torrent-listings-name" style="font-size: 16px;" href="{{ route('torrent', ['id' => $torrent->id]) }}">
                                        {{ $torrent->name }}
                                    </a>
                                    @php $current = App\Models\History::where('user_id', '=', $user->id)->where('torrent_id', '=', $torrent->id)->first() @endphp
                                    @if ($current)
                                        @if ($current->seeder == 1 && $current->active == 1)
                                            <button class="btn btn-success btn-circle torrent-listings-seeding" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('torrent.currently-seeding') }}!">
                                                <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i>
                                            </button>
                                        @endif

                                        @if ($current->seeder == 0 && $current->active == 1)
                                            <button class="btn btn-warning btn-circle torrent-listings-leeching" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('torrent.currently-leeching') }}!">
                                                <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i>
                                            </button>
                                        @endif

                                        @if ($current->seeder == 0 && $current->active == 0 && $current->completed_at == null)
                                            <button class="btn btn-info btn-circle torrent-listings-incomplete" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('torrent.not-completed') }}!">
                                                <i class="{{ config('other.font-awesome') }} fa-spinner"></i>
                                            </button>
                                        @endif

                                        @if ($current->seeder == 1 && $current->active == 0 && $current->completed_at != null)
                                            <button class="btn btn-danger btn-circle torrent-listings-complete" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('torrent.completed-not-seeding') }}!">
                                                <i class="{{ config('other.font-awesome') }} fa-thumbs-down"></i>
                                            </button>
                                        @endif
                                    @endif
                                    <br>
                                    @if ($torrent->anon === 0)
                                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} {{ $torrent->user->group->icon }}"></i>
                                    <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                        {{ $torrent->user->username }}
                                    </a>
                                </span> |
                                    @else
                                        <span class="torrent-listings-uploader">
									<i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									{{ strtoupper(trans('common.anonymous')) }}
                                            @if ($user->group->is_modo || $torrent->user->username === $user->username)
                                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                                            ({{ $torrent->user->username }})
                                        </a>
                                            @endif
                                </span> |
                                    @endif
                                    <span class='text-pink torrent-listings-thanks'>
                                <i class="{{ config('other.font-awesome') }} fa-heartbeat"></i> {{ $torrent->thanks_count }}
                            </span> |
                                    <span class='text-green torrent-listings-comments'>
								<i class="{{ config('other.font-awesome') }} fa-comment-alt-lines"></i> {{ $torrent->comments_count }}
							</span>
                                    @if ($torrent->internal == 1)
                                         | <span class='text-bold torrent-listings-internal'>
                                    <i class='{{ config('other.font-awesome') }} fa-magic' data-toggle='tooltip' title=''
                                       data-original-title='{{ __('torrent.internal-release') }}' style="color: #baaf92;"></i>
                                </span>
                                    @endif

                                    @if ($torrent->personal_release == 1)
                                         | <span class='text-bold torrent-listings-personal'>
                                    <i class='{{ config('other.font-awesome') }} fa-user-plus' data-toggle='tooltip' title=''
                                       data-original-title='Personal Release' style="color: #865be9;"></i>
                                </span>
                                    @endif

                                    @if ($torrent->stream == 1)
                                         | <span class='text-bold torrent-listings-stream-optimized'>
                                    <i class='{{ config('other.font-awesome') }} fa-play text-red' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.stream-optimized') }}'></i>
                                </span>
                                    @endif

                                    @if ($torrent->featured == 0)
                                        @if ($torrent->doubleup == 1)
                                             | <span class='text-bold torrent-listings-double-upload'>
                                        <i class='{{ config('other.font-awesome') }} fa-gem text-green' data-toggle='tooltip'
                                           title='' data-original-title='{{ __('torrent.double-upload') }}'></i>
                                    </span>
                                        @endif
                                        @if ($torrent->free == 1 || config('other.freeleech') == 1)
                                            | <span class='text-bold torrent-listings-freeleech'>
                                        <i class='{{ config('other.font-awesome') }} fa-star text-gold' data-toggle='tooltip'
                                           title='' data-original-title='{{ __('torrent.freeleech') }}'></i>
                                    </span>
                                        @endif
                                    @endif

                                    @if ($personal_freeleech)
                                         | <span class='text-bold torrent-listings-personal-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-id-badge text-orange' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.personal-freeleech') }}'></i>
                                </span>
                                    @endif

                                    @if ($user->freeleechTokens->where('torrent_id', $torrent->id)->first())
                                         | <span class='text-bold torrent-listings-freeleech-token'>
                                    <i class='{{ config('other.font-awesome') }} fa-star text-bold' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.freeleech-token') }}'></i>
                                </span>
                                    @endif

                                    @if ($torrent->featured == 1)
                                         | <span class='text-bold torrent-listings-featured' style='background-image:url(/img/sparkels.gif);'>
                                    <i class='{{ config('other.font-awesome') }} fa-certificate text-pink' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.featured') }}'></i>
                                </span>
                                    @endif

                                    @if ($user->group->is_freeleech == 1)
                                         | <span class='text-bold torrent-listings-special-freeleech'>
                                    <i class='{{ config('other.font-awesome') }} fa-trophy text-purple' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.special-freeleech') }}'></i>
                                </span>
                                    @endif

                                    @if (config('other.doubleup') == 1)
                                         | <span class='text-bold torrent-listings-global-double-upload'>
                                    <i class='{{ config('other.font-awesome') }} fa-globe text-green' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.global-double-upload') }}'></i>
                                </span>
                                    @endif

                                    @if ($user->group->is_double_upload == 1)
                                         | <span class='text-bold torrent-listings-special-double-upload'>
									<i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                       data-toggle='tooltip' title='' data-original-title='{{ __('torrent.special-double_upload') }}'></i>
								</span>
                                    @endif

                                    @if ($torrent->leechers >= 5)
                                         | <span class='text-bold torrent-listings-hot'>
                                    <i class='{{ config('other.font-awesome') }} fa-fire text-orange' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('common.hot') }}'></i>
                                </span>
                                    @endif

                                    @if ($torrent->sticky == 1)
                                         | <span class='text-bold torrent-listings-sticky'>
                                    <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.sticky') }}'></i>
                                </span>
                                    @endif

                                    @if ($torrent->highspeed == 1)
                                         | <span class='text-bold torrent-listings-high-speed'>
									<i class='{{ config('other.font-awesome') }} fa-tachometer text-red' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('common.high-speeds') }}'></i>
								</span>
                                    @endif

                                    @if ($torrent->sd == 1)
                                         | <span class='text-bold torrent-listings-sd'>
									<i class='{{ config('other.font-awesome') }} fa-ticket text-orange' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.sd-content') }}'></i>
								</span>
                                    @endif

                                    @if ($torrent->bumped_at != $torrent->created_at && $torrent->bumped_at < Carbon\Carbon::now()->addDay(2))
                                         | <span class='text-bold torrent-listings-bumped'>
                                    <i class='{{ config('other.font-awesome') }} fa-level-up-alt text-gold' data-toggle='tooltip'
                                       title='' data-original-title='{{ __('torrent.recent-bumped') }}'></i>
                                </span>
                                    @endif
                                </td>
                                <td class="torrent-listings-download" style="vertical-align: middle;">
                                    @if (config('torrent.download_check_page') == 1)
                                        <a href="{{ route('download_check', ['id' => $torrent->id]) }}">
                                            <button class="btn btn-primary" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('common.download') }}">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('download', ['id' => $torrent->id]) }}">
                                            <button class="btn btn-primary" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('common.download') }}">
                                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if (config('torrent.magnet') == 1)
                                        <a href="magnet:?dn={{ $torrent->name }}&xt=urn:btih:{{ $torrent->info_hash }}&as={{ route('torrent.download.rsskey', ['id' => $torrent->id, 'rsskey' => $user->rsskey ]) }}&tr={{ route('announce', ['passkey' => $user->passkey]) }}&xl={{ $torrent->size }}">
                                            <button class="btn btn-primary" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('common.magnet') }}">
                                                <i class="{{ config('other.font-awesome') }} fa-magnet"></i>
                                            </button>
                                        </a>
                                    @endif
                                        @livewire('small-bookmark-button', ['torrent' => $torrent->id], key($torrent->id))
                                </td>
                                <td class="torrent-listings-tmdb" style="vertical-align: middle;">
                                    @if ($torrent->category->game_meta)
										<img src="{{ url('img/igdb.png') }}" alt="igdb_id" style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->igdb }}
	                                    <br>
										<span class="{{ \rating_color(round($meta->rating) ?? 'text-white') }}"><i class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->rating_count ?? 0 }}/100 </span>
                                    @endif
                                    @if ($torrent->category->movie_meta || $torrent->category->tv_meta || $torrent->category->cartoon_meta || $torrent->category->cartoontv_meta)
	                                    <a href="{{ route('torrents.similar', ['category_id' => $torrent->category_id, 'tmdb' => $torrent->tmdb]) }}">
											<img src="{{ url('img/tmdb_small.png') }}" alt="igdb_id" style="margin-left: -5px;" width="24px" height="24px"> {{ $torrent->tmdb }}
	                                    </a>
	                                    <br>
										<span class="{{ \rating_color($meta->vote_average ?? 'text-white') }}"><i class="{{ config('other.font-awesome') }} fa-star-half-alt"></i> {{ $meta->vote_average ?? 0 }}/10 </span>
                                    @endif
                                </td>
                                <td class="torrent-listings-size" style="vertical-align: middle;">
                                {{ $torrent->getSize() }}
                                </td>
                                <td class="torrent-listings-seeders" style="vertical-align: middle;">
                                    @if (auth()->user()->group->is_modo)
                                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    @endif
                                    <span class='text-green'>
	                                    {{ $torrent->seeders }}
                                    </span>
                                    </a>
                                </td>
                                <td class="torrent-listings-leechers" style="vertical-align: middle;">
                                    @if (auth()->user()->group->is_modo)
                                    <a href="{{ route('peers', ['id' => $torrent->id]) }}">
                                    @endif
                                    <span class='text-red'>
	                                    {{ $torrent->leechers }}
                                    </span>
                                    </a>
                                </td>
                                <td class="torrent-listings-completed" style="vertical-align: middle;">
                                    @if (auth()->user()->group->is_modo)
                                    <a href="{{ route('history', ['id' => $torrent->id]) }}">
                                    @endif
                                    <span class='text-orange'>
	                                    {{ $torrent->times_completed }}
                                    </span>
                                    </a>
                                </td>
                                <td class="torrent-listings-age" style="vertical-align: middle;">
								{{ date('d.m.Y', $torrent->created_at->getTimestamp()) }}
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $torrents->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection