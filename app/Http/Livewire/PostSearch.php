<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PostSearch extends Component
{
    use WithPagination;

    public String $search = '';

    final public function updatingSearch(): void
    {
        $this->resetPage();
    }

    final public function getPostsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Post::query()
            ->select('posts.*')
            ->with('user', 'user.group', 'user.topics', 'user.posts', 'topic', 'tips')
            ->withCount([
                'likes'                  => fn ($query) => $query->where('like', '=', 1),
                'likes as dislike_count' => fn ($query) => $query->where('dislike', '=', 1),
            ])
            ->join('topics', 'topics.id', '=', 'posts.topic_id')
            ->join(
                'permissions',
                fn ($query) => $query
                    ->on('permissions.forum_id', '=', 'topics.forum_id')
                    ->on('permissions.group_id', '=', DB::raw((int) auth()->user()->group->id))
                    ->on('permissions.show_forum', '=', DB::raw(1))
                    ->on('permissions.read_topic', '=', DB::raw(1))
            )
            ->when($this->search !== '', fn ($query) => $query->where('content', 'LIKE', '%'.$this->search.'%'))
            ->orderByDesc('created_at')
            ->paginate(25);
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.post-search', [
            'posts' => $this->posts,
        ]);
    }
}
