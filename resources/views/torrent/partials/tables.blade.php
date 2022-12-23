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
                        <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
                            <span style="color:#ffffff; background-image:{{ $torrent->user->group->effect }};">
                                <i class="{{ $torrent->user->group->icon }}" data-toggle="tooltip" data-original-title="{{ $torrent->user->group->name }}"></i> {{ $torrent->user->username }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2 page">
                <div class="infobox">
                    <span class="fondata">
                        {{ __('torrent.freeleech') }}
                    </span>
                    <div class="numup" style="padding-top:5px;">

                                            <tr class="success torrent-discounts">
                                                <td>

                                                        @if (config('other.freeleech') == 1)
                                                                <i class="{{ config('other.font-awesome') }} fa-star text-gold" title="<p>{{ __('torrent.global-freeleech') }}</p>"></i>

                                                        @elseif ($freeleech_token)
                                                                <i class="{{ config('other.font-awesome') }} fa-star text-gold" title="<p>{{ __('common.fl_token') }}</p>"></i>

                                                        @elseif ($personal_freeleech)
                                                                <i class="{{ config('other.font-awesome') }} fa-star text-gold" title="<p>{{ __('common.personal') }} {{ __('torrent.freeleech') }}</p>"></i>

                                                        @elseif ($torrent->free >= '90')
                                                                <i class="{{ config('other.font-awesome') }} fa-star text-gold" data-toggle="tooltip" data-html="true" title="<p>{{ $torrent->free }}% {{ __('torrent.freeleech') }}</p>"></i>
                                                                @if ($torrent->fl_until !== null) <p style="font-size: 12px;">Poteče {{ Illuminate\Support\Carbon::now()->createFromTimestamp(strtotime($torrent->fl_until))->format('d.m.Y') }}</p> @endif
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
                                                                <i class="star50 {{ config('other.font-awesome') }} fa-star" data-toggle="tooltip" data-html="true" title="<p>{{ $torrent->free }}% {{ __('torrent.freeleech') }}</p>"></i>
                                                                @if ($torrent->fl_until !== null) <p style="font-size: 12px;">Poteče {{ Illuminate\Support\Carbon::now()->createFromTimestamp(strtotime($torrent->fl_until))->format('d.m.Y') }}</p> @endif
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
                                                                <i class="star30 {{ config('other.font-awesome') }} fa-star" data-toggle="tooltip" data-html="true" title="<p>{{ $torrent->free }}% {{ __('torrent.freeleech') }}</p>"></i>
                                                                @if ($torrent->fl_until !== null) <p style="font-size: 12px;">Poteče {{ Illuminate\Support\Carbon::now()->createFromTimestamp(strtotime($torrent->fl_until))->format('d.m.Y') }}</p> @endif

                                                        @elseif (config('other.freeleech') == '1')
                                                            <span class="badge-extra text-bold">
                                                                <i class="{{ config('other.font-awesome') }} fa-star text-gold" data-toggle="tooltip" data-html="true" title="<p>{{ $torrent->free }}% {{ __('torrent.freeleech') }}</p>"></i>
                                                            </span>
														@else
														NI
                                                        @endif
                                                </td>
                                            </tr>

                    </div>
                </div>
            </div>
        </div>
    <!--Tables-->