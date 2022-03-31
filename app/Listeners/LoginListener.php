<?php

namespace App\Listeners;

use Carbon\Carbon;

class LoginListener
{
    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        // Update Login Timestamp
        $event->user->last_login = Carbon::now();
        $event->user->save();
    }
}
