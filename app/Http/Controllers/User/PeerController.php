<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeerController extends Controller
{
    /**
     * Show user peers.
     */
    public function index(Request $request, User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        abort_unless($request->user()->group->is_modo || $request->user()->id == $user->id, 403);

        $history = DB::table('history')
            ->where('user_id', '=', $user->id)
            ->where('created_at', '>', $user->created_at)
            ->selectRaw('sum(actual_uploaded) as upload')
            ->selectRaw('sum(uploaded) as credited_upload')
            ->selectRaw('sum(actual_downloaded) as download')
            ->selectRaw('sum(downloaded) as credited_download')
            ->first();

        return view('user.peer.index', [
            'user'    => $user,
            'history' => $history,
        ]);
    }

    /**
     * Delete user peers.
     */
    public function massDestroy(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        abort_unless($request->user()->id == $user->id, 403);

        // Check if User can flush
        if ($request->user()->own_flushes == 0) {
            return redirect()->back()->withErrors('Izpirate lahko samo dvakrat na dan!');
        }

        // Only peers older than 70 minutes are allowed to be flushed otherwise users could use this to exploit leech slots
        $cutoff = (new Carbon())->copy()->subMinutes(70)->toDateTimeString();

        $user->peers()
            ->where('updated_at', '<', $cutoff)
            ->delete();

        $user->history()
            ->where('updated_at', '<', $cutoff)
            ->update(['active' => false]);

        $user->own_flushes--;

        return redirect()->back()->withSuccess('Vsi vrstniki, nazadnje najavljeni od odjemalca pred več kot 70 minutami, so bili uspešno spraznjeni!');
    }
}
