<?php

namespace App\Http\Livewire;

use App\Models\Torrent;
use App\Models\User;
use Livewire\Component;

class BookmarkButton extends Component
{
    public Torrent $torrent;
    public User $user;
    public bool $isBookmarked;

    final public function store(): void
    {
        if ($this->user->bookmarks()->where('torrent_id', '=', $this->torrent->id)->exists()) {
            $this->dispatchBrowserEvent('error', ['type' => 'error',  'message' => 'Torrent je že dodan med zaznamke!']);

            return;
        }

        $this->user->bookmarks()->attach($this->torrent->id);
        $this->isBookmarked = true;
        $this->dispatchBrowserEvent('success', ['type' => 'success',  'message' => 'Torrent je bil uspešno dodan med zaznamke!']);
    }

    final public function destroy(): void
    {
        $this->user->bookmarks()->detach($this->torrent->id);
        $this->isBookmarked = false;
        $this->dispatchBrowserEvent('success', ['type' => 'success',  'message' => 'Torrent je bil uspešno odstranjen iz zaznamkov!']);
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.bookmark-button');
    }
}
