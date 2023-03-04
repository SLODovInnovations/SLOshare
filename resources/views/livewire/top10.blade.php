<div style="display: contents">
    @foreach([
        'Top 10 (Dan)'       => $torrentsDay,
        'Top 10 (Teden)'      => $torrentsWeek,
        'Top 10 (Mesec)'     => $torrentsMonth,
        'Top 10 (Leto)'      => $torrentsYear,
        'Top 10 (Ves Čas)'  => $torrentsAll
    ] as $title => $torrents)
        <section class="panelV2">
            <h2 class="panel__heading">{{ $title }}</h2>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <tbody>
                        @foreach($torrents->loadExists([
                            'bookmarks'       => fn ($query) => $query->where('user_id', '=', auth()->id()),
                            'freeleechTokens' => fn ($query) => $query->where('user_id', '=', auth()->id()),
                        ]) as $torrent)
                            @php
                                $meta = match(true) {
                                    $torrent->category->tv_meta && $torrent->tmdb != 0        => App\Models\Tv::where('id', '=', $torrent->tmdb)->first(),
                                    $torrent->category->cartoontv_meta && $torrent->tmdb != 0 => App\Models\CartoonTv::where('id', '=', $torrent->tmdb)->first(),
                                    $torrent->category->movie_meta && $torrent->tmdb != 0     => App\Models\Movie::where('id', '=', $torrent->tmdb)->first(),
                                    $torrent->category->cartoon_meta && $torrent->tmdb != 0   => App\Models\Cartoon::where('id', '=', $torrent->tmdb)->first(),
                                    $torrent->category->game_meta && $torrent->igdb != 0      => MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb),
                                    default                                                   => null,
                                };
                            @endphp
                            <x-torrent.row :$torrent :$meta :$personalFreeleech />
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach
</div>
