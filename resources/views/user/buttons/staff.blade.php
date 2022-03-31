<div class="text-center mt-20">
    <a href="{{ route('user_resurrections', ['username' => $user->username]) }}" class="btn btn-primary">
        {{ __('user.resurrections') }}
    </a>
    <a href="{{ route('torrents') }}?bookmarked=1" class="btn btn-sm btn-primary">
        {{ __('user.bookmarks') }}
    </a>
    <a href="{{ route('wishes.index', ['username' => $user->username]) }}" class="btn btn-primary">
        {{ __('user.wishlist') }}
    </a>
    <a href="{{ route('seedboxes.index', ['username' => $user->username]) }}">
        <button class="btn btn-primary">
            {{ __('user.seedboxes') }}</button>
    </a>
    <a href="{{ route('invites.index', ['username' => $user->username]) }}"><span
                class="btn btn-primary">{{ __('user.invites') }}</span></a>
</div>
