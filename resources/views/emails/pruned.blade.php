@component('mail::message')
    # {{ __('email.pruned-header') }}!
    Vaš račun je bil trajno odstranjen iz uporabe na {{ config('other.title') }} zaradi dolgotrajne neaktivnosti!
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
