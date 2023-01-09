<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreGiftRequest;
use App\Models\PrivateMessage;
use App\Models\User;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\GiftControllerTest
 */
class GiftController extends Controller
{
    /**
     * Send Gift Form.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.gift.index');
    }

    /**
     * Send The Gift.
     */
    public function store(StoreGiftRequest $request): \Illuminate\Http\RedirectResponse
    {
        $staff = $request->user();
        $recipient = User::where('username', '=', $request->username)->sole();

        //$recipient->seedbonus += $request->seedbonus;
        //$recipient->invites += $request->invites;
        //$recipient->fl_tokens += $request->fl_tokens;
        $recipient->uploaded += $request->uploaded;
        $recipient->save();

        PrivateMessage::create([
            'sender_id'   => 1,
            'receiver_id' => $recipient->id,
            'subject'     => 'Prejeli ste sistemsko ustvarjeno darilo',
            'message'     => \sprintf('Želeli smo vas samo obvestiti o nagradi, %s, prijeli ste na vaš račun %s Bonus Points, %s (Bytes) Uploaded.
            [color=red][b]TO JE AVTOMATIZOVANO SISTEMSKO SPOROČILO, PROSIMO, NE ODGOVARAJTE![/b][/color]', $staff->username, $request->uploaded)
        ]);

        return \to_route('staff.gifts.index')
            ->withSuccess('Darilo poslano');
    }
}
