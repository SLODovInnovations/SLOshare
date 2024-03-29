<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\GroupsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FollowController
 */
class FollowControllerTest extends TestCase
{
    /** @test */
    public function destroy_returns_an_ok_response(): void
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(GroupsTableSeeder::class);

        $user = User::factory()->create();

        $userToFollow = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('users.followers.destroy', ['user' => $userToFollow]));

        $response->assertRedirect(route('users.show', ['username' => $userToFollow->username]))
            ->assertSessionHas('success', sprintf(trans('user.follow-revoked'), $userToFollow->username));

        $this->assertDatabaseMissing('follows', [
            'user_id'   => $user->id,
            'target_id' => $userToFollow->id,
        ]);
    }

    /** @test */
    public function store_returns_an_ok_response(): void
    {
        $this->seed(UsersTableSeeder::class);
        $this->seed(GroupsTableSeeder::class);

        $user = User::factory()->create();

        $userToFollow = User::factory()->create();

        $response = $this->actingAs($user)->post(route('users.followers.store', ['user' => $userToFollow]));

        $response->assertRedirect(route('users.show', ['username' => $userToFollow->username]))
            ->assertSessionHas('success', sprintf(trans('user.follow-user'), $userToFollow->username));
    }
}
