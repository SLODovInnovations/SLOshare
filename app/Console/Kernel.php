<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('auto:group ')->daily();
        $schedule->command('auto:nerdstat ')->hourly();
        $schedule->command('auto:graveyard')->daily();
        $schedule->command('auto:highspeed_tag')->hourly();
        $schedule->command('auto:prewarning')->hourly();
        $schedule->command('auto:warning')->daily();
        $schedule->command('auto:deactivate_warning')->hourly();
        $schedule->command('auto:flush_peers')->hourly();
        $schedule->command('auto:bon_allocation')->hourly();
        $schedule->command('auto:remove_personal_freeleech')->hourly();
        $schedule->command('auto:remove_featured_torrent')->hourly();
        $schedule->command('auto:recycle_invites')->daily();
        $schedule->command('auto:recycle_activity_log')->daily();
        $schedule->command('auto:recycle_failed_logins')->daily();
        $schedule->command('auto:disable_inactive_users')->daily();
        $schedule->command('auto:softdelete_disabled_users')->daily();
        $schedule->command('auto:recycle_claimed_torrent_requests')->daily();
        $schedule->command('auto:correct_history')->daily();
        $schedule->command('auto:sync_peers')->daily();
        $schedule->command('auto:email-blacklist-update')->weekends();
        $schedule->command('auto:reset_user_flushes')->daily();
        $schedule->command('auto:stats_clients')->daily();
        $schedule->command('auto:remove_torrent_buffs')->hourly();
        $schedule->command('auto:torrent_balance')->hourly();
        //$schedule->command('auto:ban_disposable_users')->weekends();
        //$schedule->command('backup:clean')->daily();
        //$schedule->command('backup:run')->daily();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
