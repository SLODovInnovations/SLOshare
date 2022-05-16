<div class="button-holder">
    <div class="button-left-large">
        <a href="{{ route('users.show', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.profile') }}
        </a>
        @if (auth()->user()->group->is_admin)
        <a href="{{ route('user_resurrections', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.resurrections') }}
        </a>
        @endif
        <a href="{{ route('user_requested', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.requested') }}
        </a>
        <a href="{{ route('torrents') }}?bookmarked=1" class="btn btn-primary">
            {{ __('user.bookmarks') }}
        </a>
        <a href="{{ route('wishes.index', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.wishlist') }}
        </a>
    </div>
</div>
