<?php

namespace App\Http\Livewire;

use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class SubscribedTopic extends Component
{
    use WithPagination;

    final public function getTopicsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Topic::query()
            ->select('topics.*')
            ->with('user', 'user.group')
            ->whereRelation('subscribedUsers', 'users.id', '=', auth()->id())
            ->whereRelation('forumPermissions', [['show_forum', '=', 1], ['group_id', '=', auth()->user()->group->id]])
            ->orderBy('last_reply_at')
            ->paginate(25, ['*'], 'subscribedTopicsPage');
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.subscribed-topic', [
            'topics' => $this->topics,
        ]);
    }
}
