<div class="button-holder">
    <div class="button-left">
        <a href="{{ route('users.show', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.profile') }}
        </a>
    </div>
</div>
