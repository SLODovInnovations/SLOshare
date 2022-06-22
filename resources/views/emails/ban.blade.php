@component('mail::message')
    # {{ __('email.banned-header') }}!
    **Razlog:** {{ $ban->ban_reason }}
    *{{ __('email.banned-footer') }}*
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
<p>{{ __('email.register-footer') }}</p>
@endcomponent