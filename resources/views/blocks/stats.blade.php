<div class="sidebar2 sidebar--inverse">
    <aside>
        <section class="panelV2">
            <h2 class="panel__heading">{{ __('stat.stats') }}</h2>
            <dl class="key-value">
                <dt>{{ __('request.requests') }}:</dt>
                <dd>{{ number_format($torrentRequestStat->total) }}</dd>
                <dt>{{ __('request.filled') }}:</dt>
                <dd>{{ number_format($torrentRequestStat->filled) }}</dd>
                <dt>{{ __('request.unfilled') }}:</dt>
                <dd>{{ number_format($torrentRequestStat->unfilled) }}</dd>
                <dt>{{ __('request.total-bounty') }}:</dt>
                <dd>{{ number_format($torrentRequestBountyStat->total) }} {{ __('bon.bon') }}</dd>
                <dt>{{ __('request.bounty-claimed') }}:</dt>
                <dd>{{ number_format($torrentRequestBountyStat->claimed) }} {{ __('bon.bon') }}</dd>
                <dt>{{ __('request.bounty-unclaimed') }}:</dt>
                <dd>{{ number_format($torrentRequestBountyStat->unclaimed) }} {{ __('bon.bon') }}</dd>
            </dl>
        </section>
    </aside>
</div>