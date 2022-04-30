    <div class="col-md-1 col-sm-1-slo col-md-br-1 col-slo-stats">
        <div class="panel-slo">

            <div class="stat">
                <p>{{ $num_torrent }}</p>
                <span class="badge-extra">{{ __('stat.total-torrents') }}</span>
            </div>

            <div class="stat">
                <p>{{ App\Helpers\StringHelper::formatBytes($torrent_size, 2) }}</p>
                <span class="badge-extra">{{ __('stat.total-torrents') }} {{ __('torrent.size') }}</span>
            </div>

            <div class="stat">
                <p>{{ $all_user }}</p>
                <span class="badge-extra">{{ __('stat.all') }} {{ __('common.users') }}</span>
            </div>

        </div>
    </div>
