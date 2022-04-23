@if (auth()->user()->group->is_admin)
<div class="col-md-5-slo col-sm-5-slo col-slo">
    <div class="panel-slo">

    <!-- Buttons -->
        <ul class="nav nav-tabs-user mb-5-user" role="tablist">
            <li class="active">
                <a href="#recommended-sloshare" role="tab" data-toggle="tab" aria-expanded="false">
                     <img src="{{ url('/icon-torrent.png') }}"> {{ __('sloshare.home-recommended-title') }}
                </a>
            </li>
    <!-- Buttons -->

<div class="tab-content">

           <div class="tab-pane fade active in" id="recommended-sloshare">
                <td class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('torrent.category') }}</th>
                                <th>{{ __('torrent.type') }}/{{ __('torrent.resolution') }}</th>
                                <th class="torrents-filename">{{ __('torrent.name') }}</th>
                                <th>{{ __('torrent.size') }}</th>
                                <th>{{ __('torrent.short-seeds') }}</th>
                                <th>{{ __('torrent.short-leechs') }}</th>
                                <th>{{ __('torrent.short-completed') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slorecommended as $recommended)

                            					@php $meta = null; @endphp
                            					@if ($recommended->category->tv_meta)
                            						@if ($recommended->tmdb || $recommended->tmdb != 0)
                            							@php $meta = App\Models\Tv::where('id', '=', $recommended->tmdb)->first(); @endphp
                            						@endif
                            					@endif
                            					@if ($recommended->category->movie_meta)
                            						@if ($recommended->tmdb || $recommended->tmdb != 0)
                            							@php $meta = App\Models\Movie::where('id', '=', $recommended->tmdb)->first(); @endphp
                            						@endif
                            					@endif
                            					@if ($recommended->category->game_meta)
                            						@if ($recommended->igdb || $recommended->igdb != 0)
                            							@php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($recommended->igdb); @endphp
                            						@endif
                            					@endif

                                <tr>

							<td class="torrent-listings-poster" style="width: 1%;">

									<div class="torrent-poster pull-left">
										@if ($recommended->tmdb != 0 && $recommended->tmdb != null)
											<img src="{{ isset($meta->poster) ? \tmdb_image('poster_small', $meta->poster) : '/img/poster/poster-torrent-1.png' }}"
											     class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
										@else
										    @if(file_exists(public_path().'/files/img/torrent-cover_'.$recommended->id.'.jpg'))
                                                <img src="{{ url('files/img/torrent-cover_' . $recommended->id . '.jpg') }}" class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
											@endif
										@endif

										@if ($recommended->category->game_meta)
											<img style="height: 80px;" src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : '/img/poster/poster-torrent-1.png' }}"
											     class="torrent-poster-img-small" alt="{{ __('torrent.poster') }}">
										@endif

                                    <td style="width: 1%;">
                                        <div class="text-center" style="padding-top: 5px;">
                                            <span class="label label-success" data-toggle="tooltip"
                                                  data-original-title="{{ __('torrent.type') }}">
                                                {{ $recommended->type->name }}
                                            </span>
                                        </div>
                                        <div class="text-center" style="padding-top: 8px;">
                                            <span class="label label-success" data-toggle="tooltip"
                                                  data-original-title="{{ __('torrent.resolution') }}">
                                                {{ $recommended->resolution->name ?? 'No Res' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <a class="text-bold" href="{{ route('torrent', ['id' => $recommended->id]) }}">
                                            {{ $recommended->name }}
                                        </a>
                                        @if (config('torrent.download_check_page') == 1)
                                            <a href="{{ route('download_check', ['id' => $recommended->id]) }}">
                                                <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('torrent.download-torrent') }}">
                                                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                                </button>
                                            </a>
                                        @else
                                            <a href="{{ route('download', ['id' => $recommended->id]) }}">
                                                <button class="btn btn-primary btn-circle" type="button" data-toggle="tooltip"
                                                    data-original-title="{{ __('torrent.download-torrent') }}">
                                                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                                </button>
                                            </a>
                                        @endif

                                        <span data-toggle="tooltip" data-original-title="{{ __('torrent.bookmark') }}"
                                            custom="newTorrentBookmark{{ $recommended->id }}" id="newTorrentBookmark{{ $recommended->id }}"
                                            torrent="{{ $recommended->id }}"
                                            state="{{ $bookmarks->where('torrent_id', $recommended->id)->count() ? 1 : 0 }}"
                                            class="torrentBookmark"></span>

                                        <br>
								        @if ($recommended->anon === 0)
									    <span class="torrent-listings-uploader">
									        <i class="{{ config('other.font-awesome') }} {{ $recommended->user->group->icon }}"></i>
                                            <a href="{{ route('users.show', ['username' => $recommended->user->username]) }}">
                                            {{ $recommended->user->username }}
                                            </a>
                                        </span> |
								        @else
									    <span class="torrent-listings-uploader">
									        <i class="{{ config('other.font-awesome') }} fa-ghost"></i>
									        {{ strtoupper(trans('common.anonymous')) }}
										@if ($user->group->is_modo || $recommended->user->username === $user->username)
											<a href="{{ route('users.show', ['username' => $recommended->user->username]) }}">
                                            ({{ $recommended->user->username }})
                                            </a>
										@endif
                                        </span> |
								        @endif

                                        <span class="text-pink">
                                            <i class="{{ config('other.font-awesome') }} fa-heart" data-toggle="tooltip"></i>
                                            {{ $recommended->thanks_count }}
                                        </span> |

                                        <span class="text-green">
                                            <i class="{{ config('other.font-awesome') }} fa-comment" data-toggle="tooltip"></i>
                                            {{ $recommended->comments_count }}
                                        </span>

                                        @if ($recommended->internal == 1)
                                          | <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-magic' data-toggle='tooltip'
                                                    title='' data-original-title='SLOshare' style="color: #baaf92;"></i>
                                                Internal
                                            </span>
                                        @endif

                                        @if ($recommended->stream == 1)
                                          | <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-play text-red'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('
                                                    torrent.stream-optimized') }}'></i> {{ __('torrent.stream-optimized') }}
                                            </span>
                                        @endif

                                        @if ($recommended->featured == 0)
                                            @if ($recommended->doubleup == 1)
                                              | <span class='text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-gem text-green'
                                                        data-toggle='tooltip' title='' data-original-title='{{ __('torrent.double-upload') }}'></i>
                                                </span>
                                            @endif
                                            @if ($recommended->free == 1 || config('other.freeleech') == 1)
                                              | <span class='text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-star text-gold'
                                                        data-toggle='tooltip' title='' data-original-title='{{ __('torrent.freeleech') }}'></i>
                                                </span>
                                            @endif
                                        @endif

                                        @if ($personal_freeleech)
                                          | <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-id-badge text-orange'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('torrent.personal-freeleech') }}'></i>
                                            </span>
                                        @endif

                                        @if ($freeleech_tokens->where('torrent_id', $recommended->id)->count())
                                          | <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-star text-bold'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('torrent.freeleech-token') }}'></i>
                                            </span>
                                        @endif

                                        @if ($recommended->featured == 1)
                                          | <span class='text-bold'
                                                style='background-image:url(/img/sparkels.gif);'>
                                                <i class='{{ config('other.font-awesome') }} fa-certificate text-pink'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('torrent.feature') }}'></i>
                                            </span>
                                        @endif

                                        @if ($user->group->is_freeleech == 1)
                                          | <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('torrent.special-freeleech') }}'></i>
                                            </span>
                                        @endif

                                        @if (config('other.doubleup') == 1)
                                            <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-globe text-green'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('torrent.global-double-upload') }}'></i>
                                            </span>
                                        @endif

                                        @if ($user->group->is_double_upload == 1)
                                          | <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-trophy text-purple'
                                                   data-toggle='tooltip' title='' data-original-title='{{ __('torrent.special-double_upload') }}'></i>
                                            </span>
                                        @endif

                                        @if ($recommended->leechers >= 5)
                                            <span class='text-bold'>
                                                <i class='{{ config('other.font-awesome') }} fa-fire text-orange'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('common.hot') }}'></i>
                                            </span>
                                        @endif

                                        @if ($recommended->sticky == 1)
                                            <span class='text-bold'>
                                              | <i class='{{ config('other.font-awesome') }} fa-thumbtack text-black'
                                                    data-toggle='tooltip' title='' data-original-title='{{ __('torrent.sticky') }}'></i>
                                            </span>
                                        @endif

                                        @if ($user->updated_at->getTimestamp() < $recommended->created_at->getTimestamp())
                                             |  <span class='text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-magic text-green'
                                                        data-toggle='tooltip' title='' data-original-title='{{ __('common.new') }}'></i>
                                                </span>
                                            @endif

                                            @if ($recommended->highspeed == 1)
                                              | <span class='text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-tachometer text-red'
                                                        data-toggle='tooltip' title='' data-original-title='{{ __('common.high-speeds') }}'></i>
                                                </span>
                                            @endif

                                            @if ($recommended->sd == 1)
                                              | <span class='text-bold'>
                                                    <i class='{{ config('other.font-awesome') }} fa-ticket text-orange'
                                                        data-toggle='tooltip' title='' data-original-title='{{ __('torrent.sd-content') }}'></i>
                                                </span>
                                            @endif
                                    </td>

                                    <td>
                                        <span>{{ $recommended->getSize() }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $recommended->seeders }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $recommended->leechers }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $recommended->times_completed }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endif