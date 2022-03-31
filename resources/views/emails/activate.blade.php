@component('mail::message')
    # {{ __('email.register-header') }} {{ config('other.title') }} !
    **{{ __('email.register-code') }}**
    @component('mail::button', ['url' => route('activate', $code), 'color' => 'blue'])
        {{ __('email.activate-account') }}
    @endcomponent
    <p>{{ __('email.register-footer') }}</p>
    <p style="word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">{{ route('activate', $code) }}</p>
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
