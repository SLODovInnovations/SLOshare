@component('mail::message')
# {{ __('email.unban-header') }}!
**Razlog:** {{ $ban->unban_reason }}


Lep pozdrav,

Ekipa {{ config('other.title') }}


Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.
E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
