@component('mail::message')
# {{ __('email.report-header') }} {{ config('other.title') }} !
**{{ __('email.report-email') }}:** {{ $report->email }}
**{{ __('email.report-link') }}:** {{ $report->url }}
**{{ __('email.report-link-hash') }}:** {{ $report->link->hash }}
**{{ __('email.report-comment') }}:** {{ $report->comment }}


Lep pozdrav,

Ekipa {{ config('other.title') }}


Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.
E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
