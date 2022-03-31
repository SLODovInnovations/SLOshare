<?php

namespace App\Console\Commands;

use App\Models\Torrent;
use Illuminate\Console\Command;

/**
 * @see \Tests\Unit\Console\Commands\SyncPeersTest
 */
class SyncPeers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sync_peers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popravi štetje torrent Seeders/Leechers (Peers) zaradi nesprejemanja zaustavljenega dogodka od stranke.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $torrents = Torrent::select(['id', 'seeders', 'leechers'])
            ->with('peers')
            ->withAnyStatus()
            ->get();

        foreach ($torrents as $torrent) {
            $torrent->seeders = $torrent->peers->where('left', '=', '0')->count();
            $torrent->leechers = $torrent->peers->where('left', '>', '0')->count();
            $torrent->save();
        }

        $this->comment('Ukaz za sinhronizacijo Torrentov je končan');
    }
}
