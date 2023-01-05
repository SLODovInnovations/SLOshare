<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class TopicController extends Controller
{
    /**
     * Show user topics.
     */
    public function index(User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $topics = $user->topics()->latest()->paginate(25);

        return \view('user.topic.index', [
            'topics' => $topics,
            'user'   => $user,
        ]);
    }
}
