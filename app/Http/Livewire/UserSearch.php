<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserSearch extends Component
{
    use WithPagination;

    public bool $show = false;

    public int $perPage = 25;

    public string $search = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    protected $queryString = [
        'search'  => ['except' => ''],
        'show'    => ['except' => false],
        'page'    => ['except' => 1],
        'perPage' => ['except' => ''],
    ];

    final public function paginationView(): string
    {
        return 'vendor.pagination.livewire-pagination';
    }

    final public function updatedPage(): void
    {
        $this->emit('paginationChanged');
    }

    final public function updatingSearch(): void
    {
        $this->resetPage();
    }

    final public function updatingShow(): void
    {
        $this->resetPage();
    }

    final public function toggleProperties($property): void
    {
        if ($property === 'show') {
            $this->show = ! $this->show;
        }
    }

    final public function getUsersProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::query()
            ->with('group')
            ->when($this->search, fn ($query) => $query->where('username', 'LIKE', '%'.$this->search.'%')->orWhere('email', 'LIKE', '%'.$this->search.'%'))
            ->when($this->show === true, fn ($query) => $query->onlyTrashed())
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    final public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return \view('livewire.user-search', [
            'users' => $this->users,
        ]);
    }
}
