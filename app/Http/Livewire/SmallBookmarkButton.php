<?php

namespace App\Http\Livewire;

use App\Models\Torrent;
use App\Models\User;
use Livewire\Component;

class SmallBookmarkButton extends Component
{
    public Torrent $torrent;
    public bool $isBookmarked;
    public User $user;

    final public function store(): void
    {
        if ($this->user->bookmarks()->where('torrent_id', '=', $this->torrent->id)->exists()) {
            $this->dispatchBrowserEvent('error', ['type' => 'error',  'message' => 'Torrent je že bil med zaznamki!']);

            return;
        }

        $this->user->bookmarks()->attach($this->torrent->id);
        $this->isBookmarked = true;
        $this->dispatchBrowserEvent('success', ['type' => 'success',  'message' => 'Torrent je bil dodan uspešno med zaznamke!']);
    }

    final public function destroy(): void
    {
        $this->user->bookmarks()->detach($this->torrent->id);
        $this->isBookmarked = false;
        $this->dispatchBrowserEvent('success', ['type' => 'success',  'message' => 'Torrent je bil uspešno odstranjen!']);
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.small-bookmark-button');
    }
}
