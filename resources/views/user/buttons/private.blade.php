<div class="button-holder">
    <div class="button-left">
        <a href="{{ route('users.show', ['username' => $user->username]) }}" class="btn btn-primary">
            {{ __('user.profile') }}
        </a>
    </div>
    <div class="button-right">
        @if (auth()->user()->group->is_admin)
            <a href="{{ route('user_settings', ['username' => $user->username]) }}" class="btn btn-danger">
                {{ __('user.settings') }}
            </a>
        @endif
        @if(auth()->user()->id == $user->id)
            <a href="{{ route('user_edit_profile_form', ['username' => $user->username]) }}">
                <button class="btn btn-danger">{{ __('user.edit-profile') }}</button>
            </a>
        @endif
    </div>
</div>
