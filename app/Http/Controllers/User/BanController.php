<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BanController extends Controller
{
    /**
     * Show user bans.
     */
    public function index(Request $request, User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        \abort_unless($request->user()->group->is_modo, 403);

        $bans = $user->userban()->latest()->get();

        return \view('user.ban.index', [
            'bans' => $bans,
            'user' => $user,
        ]);
    }
}
