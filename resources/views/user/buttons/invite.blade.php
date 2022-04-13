<div class="button-holder">
    <div class="button-left">
        <a href="{{ route('users.show', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.profile') }}
        </a>
        @if(auth()->user()->id == $user->id)
            <a href="{{ route('invites.index', ['username' => $user->username]) }}" class="btn btn-primary">
                {{ __('user.invites') }}
            </a>
            <a href="{{ route('invites.create') }}" class="btn btn-success">
                <i class="{{ config('other.font-awesome') }} fa-gift"></i> {{ __('user.send-invite') }}
            </a>
        @endif
    </div>
</div>
