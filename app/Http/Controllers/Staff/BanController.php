<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Mail\BanUser;
use App\Mail\UnbanUser;
use App\Models\Ban;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\BanControllerTest
 */
class BanController extends Controller
{
    /**
     * Display All Bans.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $bans = Ban::latest()->paginate(25);

        return \view('Staff.ban.index', ['bans' => $bans]);
    }

    /**
     * Ban A User (current_group -> banned).
     *
     * @throws \Exception
     */
    public function store(Request $request, string $username): \Illuminate\Http\RedirectResponse
    {
        $user = User::where('username', '=', $username)->firstOrFail();
        $staff = $request->user();
        $bannedGroup = \cache()->rememberForever('banned_group', fn () => Group::where('slug', '=', 'banned')->pluck('id'));

        \abort_if($user->group->is_modo || $request->user()->id == $user->id, 403);

        $user->group_id = $bannedGroup[0];
        $user->can_upload = 0;
        $user->can_download = 0;
        $user->can_comment = 0;
        $user->can_invite = 0;
        $user->can_request = 0;
        $user->can_chat = 0;

        $ban = new Ban();
        $ban->owned_by = $user->id;
        $ban->created_by = $staff->id;
        $ban->ban_reason = $request->input('ban_reason');

        $v = \validator($ban->toArray(), [
            'ban_reason' => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('users.show', ['username' => $user->username])
                ->withErrors($v->errors());
        }

        $user->save();
        $ban->save();
        // Send Email
        Mail::to($user->email)->send(new BanUser($user->email, $ban));

        return \to_route('users.show', ['username' => $user->username])
            ->withSuccess('Uporabnik je zdaj prepovedan!');
    }

    /**
     * Unban A User (banned -> new_group).
     */
    public function update(Request $request, string $username): \Illuminate\Http\RedirectResponse
    {
        $user = User::where('username', '=', $username)->firstOrFail();
        $staff = $request->user();

        \abort_if($user->group->is_modo || $request->user()->id == $user->id, 403);

        $user->group_id = $request->input('group_id');
        $user->can_upload = 1;
        $user->can_download = 1;
        $user->can_comment = 1;
        $user->can_invite = 1;
        $user->can_request = 1;
        $user->can_chat = 1;

        $ban = new Ban();
        $ban->owned_by = $user->id;
        $ban->created_by = $staff->id;
        $ban->unban_reason = $request->input('unban_reason');
        $ban->removed_at = Carbon::now();

        $v = \validator($request->all(), [
            'group_id'     => 'required',
            'unban_reason' => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('users.show', ['username' => $user->username])
                ->withErrors($v->errors());
        }

        $user->save();
        $ban->save();
        // Send Email
        Mail::to($user->email)->send(new UnbanUser($user->email, $ban));

        return \to_route('users.show', ['username' => $user->username])
            ->withSuccess('Uporabnik je zdaj oproščen prepovedi!');
    }
}
