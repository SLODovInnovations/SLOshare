@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('pages.show', ['id' => $page->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $page->name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container box">
        <div class="col-md-12 page">
            <article class="page-content">
                @joypixels($page->getContentHtml())
            </article>
        </div>
    </div>
@endsection

@section('javascripts')
    @if(request()->url() === config('other.rules_url') && auth()->user()->read_rules == 0)
        <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
          window.onscroll = function () {
            let scrollHeight, totalHeight
            scrollHeight = document.body.scrollHeight
            totalHeight = window.scrollY + window.innerHeight

            if (totalHeight >= scrollHeight) {
              Swal.fire({
                title: '<strong>Ste prebrali SLOshare Pravila?</strong>',
                text: 'Ali popolnoma razumete naša pravila?',
                text: 'Če jih ne nam pišite!',
                icon: 'question',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> SEM SEZNANJEN Z PRAVILI!',
              }).then(function () {
                $.ajax({
                  url: '/users/accept-rules',
                  type: 'post',
                  data: {
                    _token: '{{ csrf_token() }}'
                  },
                  success: function (response) {
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
                  },
                  failure: function (response) {
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
              })
            }
          }

        </script>
    @endif
@endsection
