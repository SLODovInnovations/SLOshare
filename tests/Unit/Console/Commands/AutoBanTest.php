<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;

/**
 * @see \App\Console\Commands\AutoBan
 */
class AutoBanTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_successfully(): void
    {
        $this->artisan('auto:ban')
            ->expectsOutput('Samodejni ukaz za prepoved uporabnikov je dokončan')
            ->assertExitCode(0)
            ->run();
    }
}
