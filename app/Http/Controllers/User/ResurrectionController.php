<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResurrectionController extends Controller
{
    /**
     * Show user resurrections.
     */
    public function index(Request $request, User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        \abort_unless($request->user()->group->is_modo || $request->user()->id == $user->id, 403);

        return \view('user.resurrection.index', ['user' => $user]);
    }
}
