<?php

namespace App\Http\Livewire;

use App\Models\Forum;
use Livewire\Component;
use Livewire\WithPagination;

class SubscribedForum extends Component
{
    use WithPagination;

    final public function getForumsProperty()
    {
        return Forum::query()
            ->where('parent_id', '!=', 0)
            ->whereRelation('subscribedUsers', 'users.id', '=', auth()->id())
            ->whereRelation('permissions', [['show_forum', '=', 1], ['group_id', '=', auth()->user()->group->id]])
            ->orderBy('position')
            ->paginate(25, ['*'], 'subscribedForumsPage');
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.subscribed-forum', [
            'forums' => $this->forums,
        ]);
    }
}
