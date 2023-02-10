<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Topic;

/**
 * @see \Tests\Feature\Http\Controllers\ForumCategoryControllerTest
 */
class ForumCategoryController extends Controller
{
    /**
     * Show The Forum Category.
     */
    public function show(int $id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        // Find the topic
        $forum = Forum::findOrFail($id);

        // Check if this is a category or forum
        if ($forum->parent_id != 0) {
            return to_route('forums.show', ['id' => $forum->id]);
        }

        // Check if the user has permission to view the forum
        if (! $forum->getPermission()->show_forum) {
            return to_route('forums.index')
                ->withErrors('Nimaš dostopa do te kategorije!');
        }

        // Fetch topics->posts in descending order
        // $topics = $forum->sub_topics()->latest('pinned')->latest('last_reply_at')->latest()->paginate(25);

        return view('forum.category_topic.index', [
            'forum' => $forum,
        ]);
    }
}
