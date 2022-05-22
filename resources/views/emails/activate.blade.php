@component('mail::message')
    # {{ __('email.register-header') }} {{ config('other.title') }} !
    **{{ __('email.register-code') }}**
    @component('mail::button', ['url' => route('activate', $code), 'color' => 'blue'])
        {{ __('email.activate-account') }}
    @endcomponent
    <p>{{ __('email.register-footer') }}</p>
    <br>
    <p>
    Dobrodošli v največjem slovenskem omrežju za prosto izmenjavo informacij! V pozdravnem sporočilu nekaj kratkih navodil,
    ki vam bodo pomagali brezkrbno in prijetno udejstovanje v naši skupnosti.
    </p>
    <br>
    <p>
    1. Uvod v skupnost SLOshare
    </p>
    <br>
    <p>
    SLOshare je interaktivni portal, ki povezuje uporabnike, do proste izmenjave informacij v svojem lastnem omrežju. Na
    portalu vsebuje SLEDILNIK (TRACKER), ki temelji na protokolu Bittorent. Torenti, med katerimi lahko v sekciji Brskaj,
    so datoteke, ki vrsto informacij in lasnosti o mnogih ostalih datotekah. To pomeni, da vam te datoteke predstavljajo
    most do odjemanja vseh možnih ostalih vsebin.
    </p>
    <br>
    <br>
    <p>
    2. Kaj potrebujem?
    </p>
    <br>
    <p>
    Za delovanje na našem portalu potrebujete aktivni registriran račun na spletni strani sloshare.eu, kar vam je ravnokar
    uspelo. Nato je potreben "Torrent client" oz. program, ki vam bo omogočal snemanje in branje .torrent datotek iz našega
    portala. Na portalu sloshare.eu je najpogosteje uporabljen in tudi toplo priporočen program qBittorrent (<a href="https://www.qbittorrent.org/">www.qbittorrent.org</a>)
    (Windows, Linux, macOS in ostala platforma).
    </p>
    <br>
    <br>
    <p>
    3. Kaj so številjke zgoraj desno ob navigaciskem meniju? Kaj je ratio?
    </p>
    <br>
    <p>
    Da ostane naš portal stabilen in omrežje karseda hiter, deluje na portalu sistem uporabniških razmerij (ratio). Zgoraj lahko
    vidite pri prvi puščici količino vašega prenosa podatkov, pri drgi količino oddanih podatkov, na naslednji vidite koliko
    koliko imate aktivnih torrentov, na predzadnji pa vidite koliko imate trenutnih prenosov, pri zadnji ikoni pa je izračunano
    vaše delilno razmerje. Za obstoj na našem portalu je pomembno, da delite prenešeno vsebino z drugimi uporabniki minmalno
    3 dni in držite razmerje nad 1. Če torej prenesete 1.700GB viliko datoteko, morate tudi najmanj 1.700GB in 3 dni tudi odsejati.
    V kolikor imate razmerje pod 1 dlje časa, boste po 5h opozorilih izključeni iz portala.
    </p>
    <br>
    <p>
    Ko končate vaše prenose torej pustite vaš torrent client še prižgan in datotek ne dajajte na pavzo ali izbrišite, da
    sejete podatke še ostalim uporabnikom na portalu in tako pripomorete k zdravem omrežju.
    </p>
    <br>
    <p>
    Razmerje je možno povišati tudi priloženimi donacijami SLOshare.
    </p>
    <br>
    <p>
    V zgornjih točkah smo vam na kratko predstavili kaj lahko vi pričakujete od našega portala in kaj ostali uporabniki
    pričakujejo od vas. Naprošamo vas, da si preberete še naš Pravilnik, Pravni pouk in FAQ.
    </p>
    <br>
    <p style="word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">{{ route('activate', $code) }}</p>
    <br>
    <p>
    Delimo, povejmo naprej in se skupaj družimo in zabavajmo :)
    </p>
    <br>
    <p>
    Vaš SLOshare.
    </p>
    <br>
    <br>
    <br>
    <p>Lep pozdrav,</p>
    <p>Ekipa {{ config('other.title') }}</p>
    <br>
    <p>Na voljo smo Vam tudi po E-Mail naslovu v primeru težave ali predlogov.</p>
    <p>E-Mail: <a href="mailto:info@sloshare.eu">info@sloshare.eu</a>
@endcomponent
