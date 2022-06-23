@component('mail::message')
    # {{ __('email.contact-header') }} {{ $input['email'] }}
    **{{ __('email.contact-name') }}:** {{ $input['contact-name'] }}
    **{{ __('email.contact-message') }}:** {{ $input['message'] }}
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
<p>{{ __('email.register-footer') }}</p>
@endcomponent