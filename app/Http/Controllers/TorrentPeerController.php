<?php

namespace App\Http\Controllers;

use App\Models\Peer;
use App\Models\Torrent;

class TorrentPeerController extends Controller
{
    /**
     * Display Peers Of A Torrent.
     */
    public function index(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $torrent = Torrent::withAnyStatus()->findOrFail($id);
        $peers = Peer::with(['user'])->where('torrent_id', '=', $id)->latest('seeder')->get();

        return \view('torrent.peers', ['torrent' => $torrent, 'peers' => $peers]);
    }
}
