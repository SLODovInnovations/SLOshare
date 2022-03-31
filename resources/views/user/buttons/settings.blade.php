<div class="button-holder">
    <div class="button-left">
        <a href="{{ route('users.show', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.profile') }}
        </a>
@if (auth()->user()->group->is_admin)
        <a href="{{ route('user_settings', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.general') }}
        </a>
@endif
        <a href="{{ route('user_security', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.security') }}
        </a>
@if (auth()->user()->group->is_admin)
        <a href="{{ route('user_privacy', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.privacy') }}
        </a>
@endif
@if (auth()->user()->group->is_admin)
        <a href="{{ route('user_notification', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.notification') }}
        </a>
@endif
    </div>
</div>
