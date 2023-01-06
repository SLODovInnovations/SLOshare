<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Show user posts.
     */
    public function index(User $user): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $posts = $user->posts()->with(['topic', 'user'])->latest()->paginate(25);

        return \view('user.post.index', [
            'posts' => $posts,
            'user'  => $user,
        ]);
    }
}
