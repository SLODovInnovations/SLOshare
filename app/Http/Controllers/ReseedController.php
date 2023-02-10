<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Torrent;
use App\Models\User;
use App\Notifications\NewReseedRequest;
use App\Repositories\ChatRepository;
use Illuminate\Http\Request;

class ReseedController extends Controller
{
    /**
     * ReseedController Constructor.
     */
    public function __construct(private readonly ChatRepository $chatRepository)
    {
    }

    /**
     * Reseed Request A Torrent.
     */
    public function store(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        // TODO: Store reseed requests so can be viewed in a table view.

        $torrent = Torrent::findOrFail($id);
        $reseed = History::where('torrent_id', '=', $torrent->id)->where('active', '=', 0)->get();

        if ($torrent->seeders <= 2) {
            // Send Notification
            foreach ($reseed as $r) {
                User::find($r->user_id)->notify(new NewReseedRequest($torrent));
            }

            $torrentUrl = href_torrent($torrent);

            $this->chatRepository->systemMessage(
                sprintf('Dame in Gospodje, pravkar je bila vložena zahteva za ponovno vnos [url=%s]%s[/url] lahko pomagaš :question:', $torrentUrl, $torrent->name)
            );

            return to_route('torrent', ['id' => $torrent->id])
                ->withSuccess('Obvestilo je bilo poslano vsem uporabnikom, ki so prenesli ta Torrent skupaj s prvotnim nalagalcem!');
        }

        return to_route('torrent', ['id' => $torrent->id])
            ->withErrors('Ta Torrent ne ustreza pravilom za zahtevo za ponovno sejanje.');
    }
}
