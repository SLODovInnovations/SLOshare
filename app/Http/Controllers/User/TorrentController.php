<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TorrentController extends Controller
{
    /**
     * Show user uploads.
     */
    public function index(Request $request, User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        \abort_unless($request->user()->group->is_modo || $request->user()->id == $user->id, 403);

        $history = DB::table('history')
            ->where('user_id', '=', $user->id)
            ->where('created_at', '>', $user->created_at)
            ->selectRaw('sum(actual_uploaded) as upload')
            ->selectRaw('sum(uploaded) as credited_upload')
            ->selectRaw('sum(actual_downloaded) as download')
            ->selectRaw('sum(downloaded) as credited_download')
            ->first();

        return \view('user.torrent.index', [
            'user'    => $user,
            'history' => $history,
        ]);
    }
}
