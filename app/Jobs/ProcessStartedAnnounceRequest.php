<?php

namespace App\Jobs;

use App\Models\History;
use App\Models\Peer;
use App\Models\Torrent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class ProcessStartedAnnounceRequest implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * ProcessStartedAnnounceRequest Constructor.
     */
    public function __construct(protected $queries, protected User $user, protected Torrent $torrent)
    {
    }

    /**
     * Get the middleware the job should pass through.
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping($this->user->id.'.'.$this->queries['info_hash'])];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get The Current Peer
        $peer = Peer::where('torrent_id', '=', $this->torrent->id)
                ->where('peer_id', $this->queries['peer_id'])
                ->where('user_id', '=', $this->user->id)
                ->first();

        // Creates a new peer if not existing
        if ($peer === null) {
            if ($this->queries['uploaded'] > 0 || $this->queries['downloaded'] > 0) {
                $this->queries['event'] = 'started';
            }

            $peer = new Peer();
        }

        // Get history information
        $history = History::where('torrent_id', '=', $this->torrent->id)
            ->where('user_id', '=', $this->user->id)
            ->first();

        // If no History record found then create one
        if ($history === null) {
            $history = new History();
            $history->user_id = $this->user->id;
            $history->torrent_id = $this->torrent->id;
            $history->info_hash = $this->queries['info_hash'];
        }

        $realUploaded = $this->queries['uploaded'];
        $realDownloaded = $this->queries['downloaded'];

        // Peer Update
        $peer->peer_id = $this->queries['peer_id'];
        $peer->md5_peer_id = \md5($this->queries['peer_id']);
        $peer->info_hash = $this->queries['info_hash'];
        $peer->ip = $this->queries['ip-address'];
        $peer->port = $this->queries['port'];
        $peer->agent = $this->queries['user-agent'];
        $peer->uploaded = $realUploaded;
        $peer->downloaded = $realDownloaded;
        $peer->seeder = $this->queries['left'] == 0;
        $peer->left = $this->queries['left'];
        $peer->torrent_id = $this->torrent->id;
        $peer->user_id = $this->user->id;
        $peer->updateConnectableStateIfNeeded();
        $peer->save();
        // End Peer Update

        // History Update
        $history->agent = $this->queries['user-agent'];
        $history->active = 1;
        $history->seeder = $this->queries['left'] == 0;
        $history->immune = $this->user->group->is_immune == 1;
        $history->uploaded += 0;
        $history->actual_uploaded += 0;
        $history->client_uploaded = $realUploaded;
        $history->downloaded += 0;
        $history->actual_downloaded += 0;
        $history->client_downloaded = $realDownloaded;
        $history->save();
        // End History Update

        // Sync Seeders / Leechers Count
        $this->torrent->seeders = Peer::where('torrent_id', '=', $this->torrent->id)
            ->where('left', '=', '0')
            ->count();
        $this->torrent->leechers = Peer::where('torrent_id', '=', $this->torrent->id)
            ->where('left', '>', '0')
            ->count();
        $this->torrent->save();
    }
}
