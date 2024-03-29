@extends('layout.default')

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('pages.index') }}" class="breadcrumb__link">
            Pages
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $page->name }}
    </li>
@endsection

@section('page', 'page__page--show')

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">{{ $page->name }}</h2>
        <div class="panel__body bbcode-rendered">
            @joypixels($page->getContentHtml())
        </div>
    </section>
@endsection

@section('sidebar')
    <section class="panelV2">
        <h2 class="panel__heading">{{ __('common.info') }}</h2>
        <dl class="key-value">
            <dt>{{ __('common.created_at') }}</dt>
            <dd>{{ $page->created_at }}</dd>
            <dt>{{ __('torrent.updated_at') }}</dt>
            <dd>{{ $page->updated_at }}</dd>
        </dl>
    </section>
@endsection

@section('javascripts')
    @if(parse_url(request()->url(), PHP_URL_PATH) === parse_url(config('other.rules_url'), PHP_URL_PATH) && auth()->user()->read_rules == 0)
        <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
          confirmRules = function () {
            let scrollHeight, totalHeight
            scrollHeight = document.body.scrollHeight
            totalHeight = Math.ceil(window.scrollY + window.innerHeight)

            if (totalHeight >= scrollHeight) {
              Swal.fire({
                title: '<strong>Ste prebrali SLOshare Pravila?</strong>',
                text: 'Ali popolnoma razumete naša pravila?',
                text: 'Če jih ne nam pišite!',
                icon: 'question',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> SEM SEZNANJEN Z PRAVILI!',
              }).then((result) => {
                if (result.isConfirmed) {
                  axios.post('/users/accept-rules')
                  const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  })

                  Toast.fire({
                    icon: 'success',
                    title: 'Hvala! Za razumevanje naših SLOshare pravil!'
                  })
                } else {
                  const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  })

                  Toast.fire({
                    icon: 'error',
                    title: 'Nekaj je šlo narobe!'
                  })
                }
              })
            }
          }
          window.onscroll = confirmRules
          window.onload = confirmRules
        </script>
    @endif
@endsection
