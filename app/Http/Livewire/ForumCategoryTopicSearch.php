<?php

namespace App\Http\Livewire;

use App\Models\Forum;
use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class ForumCategoryTopicSearch extends Component
{
    use WithPagination;

    public String $search = '';
    public String $sortField = 'last_reply_at';
    public String $sortDirection = 'desc';
    public String $label = '';
    public String $state = '';
    public String $subscribed = '';
    public Forum $category;

    final public function mount(Forum $category): void
    {
        $this->category = $category;
    }

    final public function updatingSearch(): void
    {
        $this->resetPage();
    }

    final public function getTopicsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Topic::query()
            ->select('topics.*')
            ->with('user', 'user.group')
            ->whereIn('forum_id', Forum::where('parent_id', '=', $this->category->id)->select('id'))
            ->whereRelation('forumPermissions', [['show_forum', '=', 1], ['group_id', '=', auth()->user()->group->id]])
            ->when($this->search !== '', fn ($query) => $query->where('name', 'LIKE', '%'.$this->search.'%'))
            ->when($this->label !== '', fn ($query) => $query->where($this->label, '=', 1))
            ->when($this->state !== '', fn ($query) => $query->where('state', '=', $this->state))
            ->when(
                $this->subscribed === 'include',
                fn ($query) => $query
                    ->whereRelation('subscribedUsers', 'users.id', '=', auth()->id())
            )
            ->when(
                $this->subscribed === 'exclude',
                fn ($query) => $query
                    ->whereDoesntHave('subscribedUsers', fn ($query) => $query->where('users.id', '=', auth()->id()))
            )
            ->orderByDesc('pinned')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(25);
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.forum-category-topic-search', [
            'topics' => $this->topics,
        ]);
    }
}
