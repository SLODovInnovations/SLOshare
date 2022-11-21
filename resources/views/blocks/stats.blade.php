<div class="sidebar2">
    <aside>
        <section class="panelV2">
            <h2 class="panel__heading">{{ __('stat.stats') }}</h2>
            <dl class="key-value">
                <dt>{{ __('stat.all') }} {{ __('common.users') }}</dt>
                <dd>{{ $all_user }}</dd>
                <dt>{{ __('stat.total-torrents') }}</dt>
                <dd>{{ $num_torrent }}</dd>
                <dt>{{ __('torrent.seeders') }}</dt>
                <dd>{{ $num_seeders }}</dd>
                <dt>{{ __('torrent.leechers') }}</dt>
                <dd>{{ $num_leechers }}</dd>
                <dt>{{ __('stat.credited') }} {{ __('stat.upload') }}</dt>
                <dd>{{ \App\Helpers\StringHelper::formatBytes($credited_upload, 2) }}</dd>
                <dt>{{ __('stat.credited') }} {{ __('stat.download') }}</dt>
                <dd>{{ \App\Helpers\StringHelper::formatBytes($credited_download, 2) }}</dd>
            </dl>
        </section>
    </aside>
</div>