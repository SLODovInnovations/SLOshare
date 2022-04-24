<!DOCTYPE html>
<html lang="{{ auth()->user()->locale }}">

<head>

<!--OGLAS-->
<script type="text/javascript" data-cfasync="false">
/*<![CDATA[/* */
(function(){var b1fe1e954bb6900189ecea7e3e3c07f8="ES3sad20WKyT0xlzC6bWt_ezHjmr47yzZFj94IoKCmYmTl2qgXPro1X9WPDbGe1gVUUJrQJs3X187A4";var a=['w61DRFPDoSLDo2jCsxI=','wod8d0DCoTnDvHF0w6UOw7dNwq0Pw5llCTvCig==','wq53NWJe','woR8ZWTCuDDDpUR/w6M5w5RN','w7vCj8K7w5/DsXx6dGdSw5zDn8Kqw7jClw==','wodKwp4=','FMO4YlY4JQ==','UT0twoPDtMKj','w5LCpEzDkMKaBw==','A8KqI1R/IXPDmcKVwpfDs1HCr8OVw6fCqsKuw5UGwrLCisOuDX/CmDo9KgsFwr3ClsKWGWLDqcOfPcK6wpnCjhIyPlXDtXcYPHt6McOjPAh+eA==','HsKTFljCqG7CjMO1BGgNw5o=','QzAwwoTDvcK6w6ETw40=','wrnDiMOcw6Axw79ea8KLwq9eMA==','dknDoX0=','wpNuAQ/DkcOhKw==','dsKjdHs=','wpBXwp7CvWRxZMOW','DFNZesKfwqwwYgbDlcKX','HR4iBBF1WMKgcEpqDg==','M8Kuwo5iw51cQcOxw4sAIcKOw5ovwrI+w6DCg1UOwqvDu3bCgx3DqlYSf14QAAtCTcKy','wqFYASsTKVo=','w5rDhhxYMsKgUFA=','wrjChxcWwpjCpRbCrMOYw5JUwoXCgng=','SMKBwos5wobDosKVNg==','ccKZF8KQbj/CtsOPEMKNw412w5Q=','w7BLWHTDpjI='];(function(b,c){var f=function(g){while(--g){b['push'](b['shift']());}};f(++c);}(a,0x92));var b=function(c,d){c=c-0x0;var e=a[c];if(b['ThoLCn']===undefined){(function(){var h=function(){var k;try{k=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');')();}catch(l){k=window;}return k;};var i=h();var j='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';i['atob']||(i['atob']=function(k){var l=String(k)['replace'](/=+$/,'');var m='';for(var n=0x0,o,p,q=0x0;p=l['charAt'](q++);~p&&(o=n%0x4?o*0x40+p:p,n++%0x4)?m+=String['fromCharCode'](0xff&o>>(-0x2*n&0x6)):0x0){p=j['indexOf'](p);}return m;});}());var g=function(h,l){var m=[],n=0x0,o,p='',q='';h=atob(h);for(var t=0x0,u=h['length'];t<u;t++){q+='%'+('00'+h['charCodeAt'](t)['toString'](0x10))['slice'](-0x2);}h=decodeURIComponent(q);var r;for(r=0x0;r<0x100;r++){m[r]=r;}for(r=0x0;r<0x100;r++){n=(n+m[r]+l['charCodeAt'](r%l['length']))%0x100;o=m[r];m[r]=m[n];m[n]=o;}r=0x0;n=0x0;for(var v=0x0;v<h['length'];v++){r=(r+0x1)%0x100;n=(n+m[r])%0x100;o=m[r];m[r]=m[n];m[n]=o;p+=String['fromCharCode'](h['charCodeAt'](v)^m[(m[r]+m[n])%0x100]);}return p;};b['KLUhYR']=g;b['YunTaF']={};b['ThoLCn']=!![];}var f=b['YunTaF'][c];if(f===undefined){if(b['jBBTeq']===undefined){b['jBBTeq']=!![];}e=b['KLUhYR'](e,d);b['YunTaF'][c]=e;}else{e=f;}return e;};var c=window;c[b('0x17',')u9B')]=[[b('0x12','2mG4'),0x4831cd],[b('0x9','G5jv'),0x0],[b('0x6','3Y1S'),'0'],[b('0x16','Pzkw'),0x0],[b('0x18','R&24'),![]],[b('0xd','A((f'),0x0],[b('0x2','u&8k'),!0x0]];var p=[b('0x3','wC@C'),b('0x13','xg@T')],l=0x0,t,j=function(){if(!p[l])return;t=c[b('0x0','4oY$')][b('0x8','rczR')](b('0x10','xg@T'));t[b('0x19','4^AR')]=b('0xe','z#nm');t[b('0xc','F2Aw')]=!0x0;var d=c[b('0x5','fDjY')][b('0xb','A((f')](b('0x11','xoyy'))[0x0];t[b('0xf','4oY$')]=b('0x7','RRn(')+p[l];t[b('0x1','ljXb')]=b('0x15','xoyy');t[b('0x4','dl[]')]=function(){l++;j();};d[b('0xa','G5jv')][b('0x14','e!p8')](t,d);};j();})();
/*]]>/* */
</script>

<!--OGLAS-->

    @include('partials.head')
</head>

@if (auth()->user()->nav == 0)

    <body hoe-navigation-type="vertical-compact" hoe-nav-placement="left" theme-layout="wide-layout">
    @else

        <body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
        @endif
        <div id="hoeapp-wrapper" class="hoe-hide-lpanel">
            @include('partials.top_nav')
            <div id="hoeapp-container" hoe-color-type="lpanel-bg5" hoe-lpanel-effect="shrink">
                @include('partials.side_nav')
                <section id="main-content">
                    @include('partials.userbar')
                    <!--@include('partials.breadcrumb')-->
                    @include('cookie-consent::index')
                    @include('partials.alerts')
                    @if (Session::has('achievement'))
                        @include('partials.achievement_modal')
                    @endif
                    @if ($errors->any())
                        <div id="ERROR_COPY" style="display: none;">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    @yield('content')
                    @include('partials.footer')
                </section>
            </div>
        </div>

        <script src="{{ mix('js/app.js') }}" crossorigin="anonymous"></script>
        <script src="{{ mix('js/sloshare.js') }}" crossorigin="anonymous"></script>
        <script src="{{ mix('js/alpine.js') }}" crossorigin="anonymous" defer></script>
        <script src="{{ mix('js/virtual-select.js') }}" crossorigin="anonymous"></script>

        @if (config('other.freeleech') == true || config('other.invite-only') == false || config('other.doubleup') == true)
            <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
              function timer () {
                return {
                  seconds: '00',
                  minutes: '00',
                  hours: '00',
                  days: '00',
                  distance: 0,
                  countdown: null,
                  promoTime: new Date('{{ config('other.freeleech_until') }}').getTime(),
                  now: new Date().getTime(),
                  start: function () {
                    this.countdown = setInterval(() => {
                      // Calculate time
                      this.now = new Date().getTime()
                      this.distance = this.promoTime - this.now
                      // Set Times
                      this.days = this.padNum(Math.floor(this.distance / (1000 * 60 * 60 * 24)))
                      this.hours = this.padNum(Math.floor((this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)))
                      this.minutes = this.padNum(Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60)))
                      this.seconds = this.padNum(Math.floor((this.distance % (1000 * 60)) / 1000))
                      // Stop
                      if (this.distance < 0) {
                        clearInterval(this.countdown)
                        this.days = '00'
                        this.hours = '00'
                        this.minutes = '00'
                        this.seconds = '00'
                      }
                    }, 100)
                  },
                  padNum: function (num) {
                    var zero = ''
                    for (var i = 0; i < 2; i++) {
                      zero += '0'
                    }
                    return (zero + num).slice(-2)
                  }
                }
              }
            </script>
        @endif

        @if (Session::has('achievement'))
            <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
              $('#modal-achievement').modal('show')
            </script>
        @endif

        @foreach (['warning', 'success', 'info'] as $key)
            @if (Session::has($key))
                <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
                  const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  })

                  Toast.fire({
                    icon: '{{ $key }}',
                    title: '{{ Session::get($key) }}'
                  })

                </script>
            @endif
        @endforeach

        @if (Session::has('errors'))
            <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
              Swal.fire({
                title: '<strong style=" color: rgb(17,17,17);">Error</strong>',
                icon: 'error',
                html: jQuery('#ERROR_COPY').html(),
                showCloseButton: true,
                willOpen: function (el) {
                  $(el).find('textarea').remove()
                }
              })

            </script>
        @endif

        <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
          window.addEventListener('success', event => {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            })

            Toast.fire({
              icon: 'success',
              title: event.detail.message
            })
          })
        </script>

        <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
          window.addEventListener('error', event => {
            Swal.fire({
              title: '<strong style=" color: rgb(17,17,17);">Error</strong>',
              icon: 'error',
              html: event.detail.message,
              showCloseButton: true,
            })
          })
        </script>

        @yield('javascripts')
        @yield('scripts')
        @livewireScripts(['nonce' => SLOYakuza\SecureHeaders\SecureHeaders::nonce()])

        <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
          Livewire.on('paginationChanged', () => {
            window.scrollTo({
              top: 15,
              left: 15,
              behaviour: 'smooth'
            })
          })
        </script>
        </body>
</html>
