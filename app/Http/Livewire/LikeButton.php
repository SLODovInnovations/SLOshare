<?php

namespace App\Http\Livewire;

use App\Models\Like;
use App\Models\Post;
use Livewire\Component;

class LikeButton extends Component
{
    public Post $post;

    public ?\Illuminate\Contracts\Auth\Authenticatable $user = null;

    final public function mount(Post $post): void
    {
        $this->user = auth()->user();
        $this->post = $post;
    }

    final public function store(): void
    {
        if ($this->user->id === $this->post->user_id) {
            $this->dispatchBrowserEvent('error', ['type' => 'error',  'message' => 'Ne morete všečkati svoje objave!']);

            return;
        }

        $exist = Like::where('user_id', '=', $this->user->id)->where('post_id', '=', $this->post->id)->first();
        if ($exist) {
            $this->dispatchBrowserEvent('error', ['type' => 'error',  'message' => 'Ta objava vam je že bila všeč ali vam ni bila všeč!']);

            return;
        }

        $new = new Like();
        $new->user_id = $this->user->id;
        $new->post_id = $this->post->id;
        $new->like = 1;
        $new->save();

        $this->dispatchBrowserEvent('success', ['type' => 'success',  'message' => 'Vaš všeček je bil uspešno uporabljen!']);
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.like-button');
    }
}
