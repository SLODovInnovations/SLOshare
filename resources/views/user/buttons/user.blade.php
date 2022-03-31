<div class="mt-20 text-center">
    <a href="{{ route('user_resurrections', ['username' => $user->username]) }}" class="btn btn-primary">
        {{ __('user.resurrections') }}
    </a>
    <a href="{{ route('torrents') }}?bookmarked=1" class="btn btn-primary">
        {{ __('user.bookmarks') }}
    </a>
    <a href="{{ route('wishes.index', ['username' => $user->username]) }}" class="btn btn-primary">
        {{ __('user.wishlist') }}
    </a>
@if (auth()->user()->group->is_admin)
    <a href="{{ route('seedboxes.index', ['username' => $user->username]) }}">
        <button class="btn btn-primary">
            {{ __('user.seedboxes') }}</button>
    </a>
    <a href="{{ route('invites.index', ['username' => $user->username]) }}"><span
                class="btn btn-primary">{{ __('user.invites') }}</span></a>
    <a href="{{ route('invites.create') }}">
        <button class="btn btn-primary">{{ __('user.send-invite') }}
        </button>
    </a>
@endif
</div>
