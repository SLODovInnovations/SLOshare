@component('mail::message')
    # Preskus E-Mail
    Vaša testna E-Mail je bila uspešno dostavljena! Izgleda, da so vaše config pošte pravilne!
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
