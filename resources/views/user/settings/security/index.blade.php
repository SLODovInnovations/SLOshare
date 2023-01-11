@extends('layout.default')

@section('title')
    <title>{{ $user->username }} - Varnost - {{ __('common.members') }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('users.show', ['username' => $user->username]) }}" class="breadcrumb__link">
            {{ $user->username }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('users.general_settings.edit', ['user' => $user]) }}" class="breadcrumb__link">
            {{ __('user.settings') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('user.security') }}
    </li>
@endsection

@section('nav-tabs')
    @include('user.buttons.user')
@endsection

@section('content')
    <div class="container">
        <div class="block">
            <div class="container-fluid p-0 some-padding">
                <ul class="nav nav-tabs" role="tablist" id="basetabs">
                    <li class="active"><a href="#password" data-toggle="tab">Geslo</a></li>
                    <li><a href="#email" data-toggle="tab">E-Mail</a></li>
                    <li><a href="#pid" data-toggle="tab">Pass Key (PID)</a></li>
                    <li><a href="#rid" data-toggle="tab">RSS Key (RID)</a></li>
                    <li><a href="#api" data-toggle="tab">API Token</a></li>
                    @if (config('auth.TwoStepEnabled') == true)
                        <li><a href="#twostep" data-toggle="tab">Avtorizacija v dveh korakih</a></li>
                    @endif
                </ul>
                <div class="tab-content">
                    <br>
                    <div role="tabpanel" class="tab-pane active" id="password">
                        <form role="form" method="POST"
                              action="{{ route('change_password', ['username' => $user->username]) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="well">
                                <h3>{{ __('user.change-password') }}.</h3>
                                <div class="help-block">{{ __('user.change-password-help') }}.</div>
                                <hr>
                                <div class="form-group">
                                    <label for="current_password">Trenutno geslo</label>
                                    <label>
                                        <input type="password" name="current_password" class="form-control"
                                               placeholder="Trenutno geslo">
                                    </label>
                                    <label for="new_password">Novo geslo</label>
                                    <label>
                                        <input type="password" name="new_password" class="form-control"
                                               placeholder="Novo geslo">
                                    </label>
                                    <label for="new_password">Ponovite geslo</label>
                                    <label>
                                        <input type="password" name="new_password_confirmation" class="form-control"
                                               placeholder="Ponovite geslo, again">
                                    </label>
                                </div>
                            </div>
                            <div class="well text-center">
                                <button type="submit" class="btn btn-primary">Spremeni geslo</button>
                            </div>
                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="email">
                        <form role="form" method="POST"
                              action="{{ route('change_email', ['username' => $user->username]) }}">
                            @csrf
                            <div class="well">
                                <h3>{{ __('user.change-email') }}.</h3>
                                <div class="help-block">{{ __('user.change-email-help') }}.</div>
                                <hr>
                                <label for="current_email">Current Email</label>
                                <p class="text-primary">{{ $user->email }}</p>
                                <label for="email">Nov E-Mail</label>
                                <label>
                                    <input class="form-control" placeholder="Nov E-Mail" name="email" type="email">
                                </label>
                            </div>
                            <div class="well text-center">
                                <button type="submit" class="btn btn-primary">Spremeni E-Mail</button>
                            </div>
                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="pid">
                        <form role="form" method="POST"
                              action="{{ route('change_pid', ['username' => $user->username]) }}">
                            @csrf
                            <div class="well">
                                <h3>{{ __('user.reset-passkey') }}.</h3>
                                <div class="help-block">{{ __('user.reset-passkey-help') }}.</div>
                                </h3>
                                <hr>

                                <div class="form-group">
                                    <label for="current_pid">Trenutni PID</label>
                                    <p class="form-control-static text-monospace current_pid">{{ $user->passkey }}</p>
                                </div>
                            </div>
                            <div class="well text-center">
                                <button type="submit" class="btn btn-primary">Ponastaviti PID</button>
                            </div>
                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="rid">
                        <form role="form" method="POST"
                              action="{{ route('change_rid', ['username' => $user->username]) }}">
                            @csrf
                            <div class="well">
                                <h3>{{ __('user.reset-rss') }}.</h3>
                                <div class="help-block">{{ __('user.reset-rss-help') }}.</div>
                                </h3>
                                <hr>

                                <div class="form-group">
                                    <label for="current_rid">Trenutni RID</label>
                                    <p class="form-control-static text-monospace current_rid">{{ $user->rsskey }}</p>
                                </div>
                            </div>
                            <div class="well text-center">
                                <button type="submit" class="btn btn-primary">Ponastaviti RID</button>
                            </div>
                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="api">
                        <form role="form" method="POST"
                              action="{{ route('change_api_token', ['username' => $user->username]) }}">
                            @csrf
                            <div class="well">
                                <h3>{{ __('user.reset-api-token') }}.</h3>
                                <div class="help-block">{{ __('user.reset-api-help') }}.</div>
                                </h3>
                                <hr>

                                <div class="form-group">
                                    <label for="current_rid">Trenutni API Token</label>
                                    <p class="form-control-static text-monospace current_api">{{ $user->api_token ?? 'Trenutno nimate API Token.' }}</p>
                                </div>
                            </div>
                            <div class="well text-center">
                                <button type="submit" class="btn btn-primary">Ponastaviti API Token</button>
                            </div>
                        </form>
                    </div>

                    @if (config('auth.TwoStepEnabled') == true)
                        <div role="tabpanel" class="tab-pane" id="twostep">
                            <form role="form" method="POST"
                                  action="{{ route('change_twostep', ['username' => $user->username]) }}">
                                @csrf
                                <div class="well">
                                    <h2 class="text-bold">Dvostopenjska avtentikacija</h2>
                                    <hr>
                                    <label for="twostep" class="control-label">Uporabite dvostopenjsko avtorizacijo?</label>
                                    <div class="radio-inline">
                                        <label><input type="radio" name="twostep" @if ($user->twostep == 1) checked
                                                      @endif
                                                      value="1">{{ __('common.yes') }}</label>
                                    </div>
                                    <div class="radio-inline">
                                        <label><input type="radio" name="twostep" @if ($user->twostep == 0) checked
                                                      @endif value="0">{{ __('common.no') }}</label>
                                    </div>
                                    <br>
                                </div>
                                <div class="well text-center">
                                    <button type="submit" class="btn btn-primary">Shrani spremembe</button>
                                </div>
                            </form>
                        </div>
                </div>
                @endif

            </div>
        </div>
    </div>
    </div>
@endsection
@section('javascripts')
    <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(window).on('load', function () {
        loadTab()
      })

      function loadTab () {
        if (window.location.hash && window.location.hash == '#password') {
          $('#basetabs a[href="#password"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#email') {
          $('#basetabs a[href="#email"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#pid') {
          $('#basetabs a[href="#pid"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#rid') {
          $('#basetabs a[href="#rid"]').tab('show')
        }
      }

    </script>
@endsection
