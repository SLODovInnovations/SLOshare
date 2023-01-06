<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * @see \Tests\Feature\Http\Controllers\AchievementsControllerTest
 */
class AchievementsController extends Controller
{
    /**
     * Display User Achievements.
     */
    public function index(User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $achievements = $user->unlockedAchievements();
        $pending = $user->inProgressAchievements();

        return \view('user.achievement.index', [
            'route'        => 'achievement',
            'user'         => $user,
            'achievements' => $achievements,
            'pending'      => $pending,
        ]);
    }
}
