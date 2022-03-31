@component('mail::message')
    # {{ __('email.disabled-header') }}!
    Vaš račun je označen kot neaktiven in vnešen v skupino invalidov. Da bi obdržali svoj račun, morate
    se rijaviti znotraj {{ config('pruning.soft_delete') }} prejema te E-Mail. Če tega ne storite, bo vaš račun
    trajno onemogočen {{ config('other.title') }}! Da bi se temu izognili v prihodnosti, se prijavite vsaj enkrat
    {{ config('pruning.last_login') }} dnevno.
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
