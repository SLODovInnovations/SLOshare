<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;

/**
 * @see \App\Console\Commands\AutoRecycleClaimedTorrentRequests
 */
class AutoRecycleClaimedTorrentRequestsTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_successfully(): void
    {
        $this->artisan('auto:recycle_claimed_torrent_requests')
            ->expectsOutput('Ukaz za ponastavitev samodejnih zahtevkov je dokončan')
            ->assertExitCode(0)
            ->run();
    }
}
