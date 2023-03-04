<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\GroupsTableSeeder;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(GroupsTableSeeder::class);
    }

    /** @test */
    public function whenNotAuthenticatedHomepageRedirectsToLogin(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function whenAuthenticatedHomepageReturns200(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('home.index'))
            ->assertOk()
            ->assertViewIs('home.index')
            ->assertViewHas('user')
            ->assertViewHas('personal_freeleech')
            ->assertViewHas('users')
            ->assertViewHas('groups')
            ->assertViewHas('articles')
            ->assertViewHas('newest')
            ->assertViewHas('video')
            ->assertViewHas('xxx')
            ->assertViewHas('tvserie')
            ->assertViewHas('game')
            ->assertViewHas('applications')
            ->assertViewHas('cartoones')
            ->assertViewHas('newsloshare')
            ->assertViewHas('slorecommended')
            ->assertViewHas('videorecommended')
            ->assertViewHas('cartoonrecommended')
            ->assertViewHas('flrecommended')
            ->assertViewHas('seeded')
            ->assertViewHas('dying')
            ->assertViewHas('leeched')
            ->assertViewHas('dead')
            ->assertViewHas('topics')
            ->assertViewHas('posts')
            ->assertViewHas('featured')
            ->assertViewHas('poll')
            ->assertViewHas('uploaders')
            ->assertViewHas('past_uploaders')
            ->assertViewHas('freeleech_tokens')
            ->assertViewHas('bookmarks')
            ->assertViewHas('all_user')
            ->assertViewHas('num_torrent')
            ->assertViewHas('num_seeders')
            ->assertViewHas('num_leechers')
            ->assertViewHas('credited_upload')
            ->assertViewHas('credited_download')
            ->assertViewHas('clients');
    }

    /** @test */
    public function whenAuthenticatedAndTwoStepRequiredHomepageRedirectsToTwoStep(): void
    {
        $user = User::factory()->create([
            'twostep' => true,
        ]);

        $this->actingAs($user)
            ->get(route('home.index'))
            ->assertRedirect(route('verificationNeeded'));
    }
}
