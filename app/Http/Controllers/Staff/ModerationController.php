<?php

namespace App\Http\Controllers\Staff;

use App\Helpers\TorrentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateModerationRequest;
use App\Models\PrivateMessage;
use App\Models\Torrent;
use App\Repositories\ChatRepository;
use Illuminate\Support\Carbon;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\ModerationControllerTest
 */
class ModerationController extends Controller
{
    /**
     * ModerationController Constructor.
     */
    public function __construct(private readonly ChatRepository $chatRepository)
    {
    }

    /**
     * Torrent Moderation Panel.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $current = Carbon::now();
        $pending = Torrent::with(['user', 'category', 'type'])->pending()->get();
        $postponed = Torrent::with(['user', 'category', 'type'])->postponed()->get();
        $rejected = Torrent::with(['user', 'category', 'type'])->rejected()->get();

        return \view('Staff.moderation.index', [
            'current'   => $current,
            'pending'   => $pending,
            'postponed' => $postponed,
            'rejected'  => $rejected,
        ]);
    }

    /**
     * Update a torrent's moderation status.
     */
    public function update(UpdateModerationRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $torrent = Torrent::withAnyStatus()->with('user')->findOrFail($id);

        if ((int) $request->old_status !== $torrent->status) {
            return \to_route('torrent', ['id' => $id])
                ->withInput()
                ->withErrors('Torrent je bil že moderiran, odkar je bila ta stran naložena.');
        }

        if ((int) $request->status === $torrent->status) {
            return \to_route('torrent', ['id' => $id])
                ->withInput()
                ->withErrors(
                    match ($torrent->status) {
                        0       => 'Torrent je že na čakanju.',
                        1       => 'Torrent je že odobren.',
                        2       => 'Torrent je že zavrnjen.',
                        3       => 'Torrent je že prestavljen.',
                        default => 'Neveljavno stanje moderiranja.'
                    }
                );
        }

        $staff = \auth()->user();

        switch ($request->status) {
            case 1: // Approve
                $appurl = \config('app.url');

                // Announce To Shoutbox
                if ($torrent->anon === 0) {
                    $this->chatRepository->systemMessage(
                        \sprintf('Uporabnik [url=%s/users/', $appurl).$torrent->user->username.']'.$torrent->user->username.\sprintf('[/url] je naložil '.$torrent->category->name.'. [url=%s/torrents/', $appurl).$id.']'.$torrent->name.'[/url], prenesi ga zdaj! :slight_smile:'
                    );
                } else {
                    $this->chatRepository->systemMessage(
                        \sprintf('Anonimni uporabnik je naložil '.$torrent->category->name.'. [url=%s/torrents/', $appurl).$id.']'.$torrent->name.'[/url], prenesi ga zdaj! :slight_smile:'
                    );
                }

                TorrentHelper::approveHelper($id);

                return \to_route('staff.moderation.index')
                    ->withSuccess('Torrent je že odobren');

            case 2: // Reject
                $torrent->markRejected();

                PrivateMessage::create([
                    'sender_id'   => $staff->id,
                    'receiver_id' => $torrent->user_id,
                    'subject'     => 'Vaš naložen Torrent, '.$torrent->name.' ,je bil preložen z strani '.$staff->username,
                    'message'     => "Lep pozdrav, \n\nVaš naložen Torrent ".$torrent->name." je bil preložen. Spodaj si oglejte sporočilo Osebja SLOshare.eu.\n\n".$request->message,
                ]);

                return \to_route('staff.moderation.index')
                    ->withSuccess('Torrent preložen');

            case 3: // Postpone
                $torrent->markPostponed();

                PrivateMessage::create([
                    'sender_id'   => $staff->id,
                    'receiver_id' => $torrent->user_id,
                    'subject'     => 'Vaš naloženi Torrent, '.$torrent->name.' ,je bil zavrnjen z strani '.$staff->username,
                    'message'     => "Lep pozdrav, \n\nVaš naloženi Torrent, ".$torrent->name." ,je bil zavrnjen. Spodaj si oglejte sporočilo Osebja SLOshare.eu.\n\n".$request->message,
                ]);

                return \to_route('staff.moderation.index')
                    ->withSuccess('Torrent zavrnjen');

            default: // Undefined status
                return \to_route('torrent', ['id' => $id])
                    ->withErrors('Neveljavno stanje moderiranja.');
        }
    }
}
