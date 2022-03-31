<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;

/**
 * @see \App\Console\Commands\AutoSoftDeleteDisabledUsers
 */
class AutoSoftDeleteDisabledUsersTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_successfully(): void
    {
        $this->artisan('auto:softdelete_disabled_users')
            ->expectsOutput('Ukaz za samodejno mehko brisanje onemogočenih uporabnikov je dokončan')
            ->assertExitCode(0)
            ->run();
    }
}
