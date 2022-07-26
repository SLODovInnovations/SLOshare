    <!--Tables-->
        <div class="container torrent-slo">
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        <i class="{{ config('other.font-awesome') }} fa-fw fa-arrow-up text-green"></i> {{ __('torrent.seeders') }}
                    </span>
                    <div class="numup text-green" style="padding-top:5px;">
                    @if (auth()->user()->group->is_admin)
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}" class="text-green">
                    @endif
                    {{ $torrent->seeders }}
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        <i class="{{ config('other.font-awesome') }} fa-fw fa-arrow-down text-red"></i> {{ __('torrent.leechers') }}
                    </span>
                    <div class="numup text-red" style="padding-top:5px;">
                    @if (auth()->user()->group->is_admin)
                    <a href="{{ route('peers', ['id' => $torrent->id]) }}" class="numup text-red">
                    @endif
                    {{ $torrent->leechers }}
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        <i class="{{ config('other.font-awesome') }} fa-fw fa-check text-info"></i> {{ __('torrent.times') }}
                    </span>
                    <div class="numup text-info" style="padding-top:5px;">
                    @if (auth()->user()->group->is_admin)
                    <a href="{{ route('history', ['id' => $torrent->id]) }}" class="text-info">
                    @endif
                    {{ $torrent->times_completed }}
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        <i class="{{ config('other.font-awesome') }} fa-fw fa-database"></i> {{ __('torrent.size') }}
                    </span>
                    <div class="numup" style="padding-top:5px;">
                    <a data-toggle="modal" href="#myModal" style="color:#ffffff;">
                    {{ $torrent->getSize() }}
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        <i class="{{ config('other.font-awesome') }} fa-fw fa-users"></i> {{ __('torrent.uploader') }}
                    </span>
                    <div class="numup" style="padding-top:5px;">
                        <a href="{{ route('users.show', ['username' => $uploader->username]) }}">
                            <span style="color:#ffffff; background-image:{{ $uploader->group->effect }};">
                                <i class="{{ $uploader->group->icon }}" data-toggle="tooltip" data-original-title="{{ $uploader->group->name }}"></i> {{ $uploader->username }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        <i class="{{ config('other.font-awesome') }} fa-fw fa-star text-gold"></i> {{ __('torrent.freeleech') }}
                    </span>
                    <div class="numup" style="padding-top:5px;">

                            @if ($torrent->featured == '0')
                                @if ($freeleech_token || $user->group->is_freeleech == '1' || $personal_freeleech || $torrent->free > '1' || config('other.freeleech') == '1' || $torrent->doubleup == '1' || $user->group->is_double_upload == '1' || config('other.doubleup') == '1')
                                    @if ($freeleech_token || $user->group->is_freeleech == '1' || $personal_freeleech || config('other.freeleech') == '1')
                                        <span class="badge-extra" data-toggle="tooltip" data-html="true" title="
                                                @if ($freeleech_token)
                                                    <p>{{ __('common.fl_token') }}</p>
                                                @endif

                                                @if ($user->group->is_freeleech == '1')
                                                    <p>{{ __('common.special') }} {{ __('torrent.freeleech') }}</p>
                                                @endif

                                                @if ($personal_freeleech)
                                                    <p>{{ __('common.personal') }} {{ __('torrent.freeleech') }}</p>
                                                @endif

                                                @if (config('other.freeleech') == '1')
                                                    <p>{{ __('common.global') }} {{ __('torrent.freeleech') }}</p>
                                                @endif
                                                ">
                                            <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                        </span>
                                    @elseif ($torrent->free > '1')
                                        @if ($torrent->free >= '90')
                                            <span class="badge-extra text-bold" data-toggle="tooltip" data-html="true"
                                                  title="<p>{{ $torrent->free }}% {{ __('common.free') }}</p>">
                                                <i class="{{ config('other.font-awesome') }} fa-star text-gold"></i>
                                                @if ($torrent->fl_until !== null) <span>{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech expires.</span> @endif
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
                                            <span class="badge-extra text-bold" data-toggle="tooltip" data-html="true"
                                                  title="<p>{{ $torrent->free }}% {{ __('common.free') }}</p>">
                                                <i class="star50 {{ config('other.font-awesome') }} fa-star"></i>
                                                @if ($torrent->fl_until !== null) <span>{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech expires.</span> @endif
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
                                            <span class="badge-extra text-bold" data-toggle="tooltip" data-html="true"
                                                  title="<p>{{ $torrent->free }}% {{ __('common.free') }}</p>">
                                                <i class="star30 {{ config('other.font-awesome') }} fa-star"></i>
                                                @if ($torrent->fl_until !== null) <span>{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->fl_until) }} Freeleech expires.</span> @endif
                                            </span>
                                        @endif
                                    @endif

                                    @if ($torrent->doubleup == '1' || $user->group->is_double_upload == '1' || config('other.doubleup') == '1')
                                        <span class="badge-extra" data-toggle="tooltip" data-html="true" title="
                                                @if ($torrent->doubleup == '1')
                                                    <p>{{ __('torrent.double-upload') }}</p>
                                                @endif

                                                @if ($user->group->is_double_upload == '1')
                                                    <p>{{ __('common.special') }} {{ __('torrent.double-upload') }}</p>
                                                @endif

                                                @if (config('other.doubleup') == '1')
                                                    <p>{{ __('common.global') }} {{ strtolower(__('torrent.double-upload')) }}</p>
                                                @endif
                                                ">
                                            <i class="{{ config('other.font-awesome') }} fa-gem text-green"></i>
                                            @if ($torrent->du_until !== null) <span>{{ Illuminate\Support\Carbon::now()->diffForHumans($torrent->du_until) }} Double Upload expires.</span> @endif
                                        </span>
                                    @endif
                                @else
                                    <span class="text-danger badge-extra" data-toggle="tooltip"
                                          title="{{ __('torrent.no-discounts') }}">
                                        <i class="{{ config('other.font-awesome') }} fa-frown"></i>
                                    </span>
                                @endif
                            @else
                                <span class="badge-extra" data-toggle="tooltip" data-html="true"
                                      title='{{ __("torrent.featured-until") }} {{ $featured->created_at->addDay(7)->toFormattedDateString() }} ({{ $featured->created_at->addDay(7)->diffForHumans() }}!) {!! __("torrent.featured-desc") !!}'>
                                    <i class="{{ config('other.font-awesome') }} fa-certificate text-orange"></i>
                                </span>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    <!--Tables-->