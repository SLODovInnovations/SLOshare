@component('mail::message')
    # {{ __('email.newreply-header') }}: {{ $topic->name }}
    **{{ __('email.newreply-message') }}:**
    <a href="{{ route('users.show', ['username' => $user->username]) }}">{{ $user->username }}</a>
    {{ strtolower(__('email.newreply-replied')) }}
    <a href="{{ route('forum_topic', ['id' => $topic->id]) }}">{{ $topic->name }}</a>
    @component('mail::button', ['url' => route('forum_topic', ['id' => $topic->id]), 'color' => 'blue'])
        {{ __('email.newreply-view') }}
        <p>Lep pozdrav,</p>
        <p>Ekipa {{ config('other.title') }}</p>
        <br>
        <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
        <p>E-Mail: <a href="info@sloshare.eu">info@sloshare.eu</a>
    @endcomponent
@endcomponent
