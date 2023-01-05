<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PrivateMessage;
use App\Models\User;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\WarningControllerTest
 */
class WarningController extends Controller
{
    /**
     * Show A Users Warnings.
     */
    public function show(Request $request, string $username): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        \abort_unless($request->user()->group->is_modo, 403);

        $user = User::where('username', '=', $username)->firstOrFail();

        $warnings = Warning::where('user_id', '=', $user->id)->with(['torrenttitle', 'warneduser'])->latest('active')->paginate(25);
        $warningcount = Warning::where('user_id', '=', $user->id)->count();

        $softDeletedWarnings = Warning::where('user_id', '=', $user->id)->with(['torrenttitle', 'warneduser'])->latest('created_at')->onlyTrashed()->paginate(25);
        $softDeletedWarningCount = Warning::where('user_id', '=', $user->id)->onlyTrashed()->count();

        return \view('user.warning.index', [
            'warnings'                => $warnings,
            'warningcount'            => $warningcount,
            'softDeletedWarnings'     => $softDeletedWarnings,
            'softDeletedWarningCount' => $softDeletedWarningCount,
            'user'                    => $user,
        ]);
    }

    /**
     * Deactivate A Warning.
     */
    public function deactivate(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        \abort_unless($request->user()->group->is_modo, 403);
        $staff = $request->user();
        $warning = Warning::findOrFail($id);
        $warning->expires_on = Carbon::now();
        $warning->active = 0;
        $warning->save();

        // Send Private Message
        $privateMessage = new PrivateMessage();
        $privateMessage->sender_id = $staff->id;
        $privateMessage->receiver_id = $warning->user_id;
        $privateMessage->subject = 'Opozorilo Hit in Run Deaktivirano';
        $privateMessage->message = $staff->username.' se je odločil deaktivirati vaše aktivno opozorilo za torrent '.$warning->torrent.' Imeli si srečo! [color=red][b]TO JE SPOROČILO SAMODEJNEGA SISTEMA, PROSIMO, NE ODGOVARJAJTE![/b][/color]';
        $privateMessage->save();

        return \to_route('warnings.show', ['username' => $warning->warneduser->username])
            ->withSuccess('Opozorilo je bilo uspešno deaktivirano');
    }

    /**
     * Deactivate All Warnings.
     */
    public function deactivateAllWarnings(Request $request, string $username): \Illuminate\Http\RedirectResponse
    {
        \abort_unless($request->user()->group->is_modo, 403);
        $staff = $request->user();
        $user = User::where('username', '=', $username)->firstOrFail();

        foreach (Warning::where('user_id', '=', $user->id)->get() as $warning) {
            $warning->expires_on = Carbon::now();
            $warning->active = 0;
            $warning->save();
        }

        // Send Private Message
        $privateMessage = new PrivateMessage();
        $privateMessage->sender_id = $staff->id;
        $privateMessage->receiver_id = $user->id;
        $privateMessage->subject = 'Deaktivirano opozorilo za vsa Hit in Run';
        $privateMessage->message = $staff->username.' se je odločil deaktivirati vsa vaša aktivna opozorila o zadetkih in tekih. Imel si srečo! [color=red][b]TO JE SPOROČILO SAMODEJNEGA SISTEMA, PROSIMO, NE ODGOVARJAJTE![/b][/color]';
        $privateMessage->save();

        return \to_route('warnings.show', ['username' => $user->username])
            ->withSuccess('Vsa opozorila so bila uspešno deaktivirana');
    }

    /**
     * Delete A Warning.
     *
     *
     * @throws \Exception
     */
    public function deleteWarning(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        \abort_unless($request->user()->group->is_modo, 403);

        $staff = $request->user();
        $warning = Warning::findOrFail($id);

        // Send Private Message
        $privateMessage = new PrivateMessage();
        $privateMessage->sender_id = $staff->id;
        $privateMessage->receiver_id = $warning->user_id;
        $privateMessage->subject = 'Opozorilo Hit in Run izbrisano';
        $privateMessage->message = $staff->username.' se je odločil izbrisati vaše opozorilo za torrent '.$warning->torrent.' Imel si srečo! [color=red][b]TO JE SPOROČILO SAMODEJNEGA SISTEMA, PROSIMO, NE ODGOVARJAJTE![/b][/color]';
        $privateMessage->save();

        $warning->deleted_by = $staff->id;
        $warning->save();
        $warning->delete();

        return \to_route('warnings.show', ['username' => $warning->warneduser->username])
            ->withSuccess('Opozorilo je bilo uspešno izbrisano');
    }

    /**
     * Delete All Warnings.
     */
    public function deleteAllWarnings(Request $request, string $username): \Illuminate\Http\RedirectResponse
    {
        \abort_unless($request->user()->group->is_modo, 403);

        $staff = $request->user();
        $user = User::where('username', '=', $username)->firstOrFail();

        foreach (Warning::where('user_id', '=', $user->id)->get() as $warning) {
            $warning->deleted_by = $staff->id;
            $warning->save();
            $warning->delete();
        }

        // Send Private Message
        $privateMessage = new PrivateMessage();
        $privateMessage->sender_id = $staff->id;
        $privateMessage->receiver_id = $user->id;
        $privateMessage->subject = 'Vsa opozorila Hit in Run so izbrisana';
        $privateMessage->message = $staff->username.' se je odločil izbrisati vsa vaša opozorila. Imel si srečo! [color=red][b]TO JE SPOROČILO SAMODEJNEGA SISTEMA, PROSIMO, NE ODGOVARJAJTE![/b][/color]';
        $privateMessage->save();

        return \to_route('warnings.show', ['username' => $user->username])
            ->withSuccess('Vsa opozorila so bila uspešno izbrisana');
    }

    /**
     * Restore A Soft Deleted Warning.
     */
    public function restoreWarning(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        \abort_unless($request->user()->group->is_modo, 403);

        $warning = Warning::withTrashed()->findOrFail($id);
        $warning->restore();

        return \to_route('warnings.show', ['username' => $warning->warneduser->username])
            ->withSuccess('Opozorilo je bilo uspešno obnovljeno');
    }
}
