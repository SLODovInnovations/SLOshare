@component('mail::message')
    # {{ __('email.disabled-header') }}!
    Vaš račun je označen kot neaktiven in je uvrščen v skupino onemogočenih. Da bi obdržali svoj račun, se morate
    prijaviti znotraj {{ config('pruning.soft_delete') }} prejema te E-Mail. Če tega ne storite, bo vaš račun
    trajno onemogočen {{ config('other.title') }}! Da bi se temu izognili v prihodnosti, se prijavite vsaj enkrat
    vsakih {{ config('pruning.last_login') }} dni.
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
<p>{{ __('email.register-footer') }}</p>
@endcomponent
