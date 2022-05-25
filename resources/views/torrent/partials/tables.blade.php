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
                        @if ($torrent->free == '1' || $torrent->free >= '90' || $torrent->free < '90' && $torrent->free >= '30' || $torrent->free < '30' && $torrent->free != '0' || config('other.freeleech') == '1')
                        JE
                        @else
                        NI
                        @endif
                    </div>
                </div>
            </div>
        </div>
    <!--Tables-->