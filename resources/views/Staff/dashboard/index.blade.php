@extends('layout.default')

@section('title')
    <title>{{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">
        {{ __('staff.staff-dashboard') }}
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.dashboardmenu')

            <div class="col-sm-5 col-lg-5">
                <div class="block" id="vue">
                    <div class="panel-body">
                        <h2 class="text-bold text-center text-green">
                            <i class="{{ config('other.font-awesome') }} fa-terminal"></i> Kodna baza
                        </h2>
                        <h3 class="text-bold text-center">Trenutno se izvaja {{ config('sloshare.codebase') }}
                            {{ config('sloshare.version') }}</h3>
                        <version></version>
                    </div>
                </div>
            </div>

            <div class="col-sm-5 col-lg-5">
                <div class="block">
                    <div class="panel-body">
                        @if (request()->secure())
                            <h2 class="text-bold text-center text-green">
                                <i class=" {{ config('other.font-awesome') }} fa-lock"></i> SSL Cert
                            </h2>
                            <h3 class="text-bold text-center">
                                {{ config('app.url') }}
                            </h3>
                            <div class="text-center" style="padding-top: 15px;">
                                <span class="text-red">Issued By: {{ (!is_string($certificate)) ? $certificate->getIssuer() : "Podatki o potrdilu niso najdeni" }}</span>
                                <br>
                                <span class="text-red">Expires: {{ (!is_string($certificate)) ? $certificate->expirationDate()->diffForHumans() : "Podatki o potrdilu niso najdeni" }}</span>
                            </div>
                        @else
                            <h2 class="text-bold text-center text-red">
                                <i class=" {{ config('other.font-awesome') }} fa-unlock"></i> SSL Cert
                            </h2>
                            <h3 class="text-bold text-center">
                                {{ config('app.url') }} -- <span class="text-muted">Povezava ni varna</span>
                            </h3>
                            <div style="padding-top: 15px;">
                                <span class="text-red text-left">Izdal: N/A</span>
                                <span class="text-red" style="float: right;">Poteče: N/A</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-10">
                <div class="block" style=" margin-top: 30px;">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <u>Statistika</u>
                        </h1>
                    </div>
                    <div class="panel-body">

                        <div class="row black-list">
                            <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">Torrenti</h1>
                                    <span class="badge-user">Skupno: {{ $torrents->total }}</span>
                                    <br>
                                    <span class="badge-user">Do: {{ $torrents->pending }}</span>
                                    <span class="badge-user">Zavrnjeni: {{ $torrents->rejected }}</span>
                                    <i class="fal fa-magnet black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">Vrstniki</h1>
                                    <span class="badge-user">Skupno: {{ $peers->total }}</span>
                                    <br>
                                    <span class="badge-user">Seeders: {{ $peers->seeders }}</span>
                                    <span class="badge-user">Leechers: {{ $peers->leechers }}</span>
                                    <i class="fal fa-wifi black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">Uporabniki</h1>
                                    <span class="badge-user">Skupaj: {{ $users->total }}</span>
                                    <br>
                                    <span class="badge-user">Čaka na potrditev: {{ $users->validating }}</span>
                                    <span class="badge-user">Banned: {{ $users->banned }}</span>
                                    <i class="fal fa-users black-icon text-green"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-10">
                <div class="block" style=" margin-top: 30px;">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <u>Informacije o strežniku</u>
                        </h1>
                    </div>
                    <div class="panel-body">

                        <div class="row black-list">
                            <div class="col-xs-6 col-sm-3 col-md-3">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">OS</h1>
                                    <span class="badge-user">Trenutno se izvaja</span>
                                    <br>
                                    <span class="badge-user">{{ $basic['os'] }}</span>
                                    <i class="fal fa-desktop black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 col-md-3">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">PHP</h1>
                                    <span class="badge-user">Trenutno se izvaja</span>
                                    <br>
                                    <span class="badge-user">php{{ $basic['php'] }}</span>
                                    <i class="fal fa-terminal black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 col-md-3">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">BAZA PODATKOV</h1>
                                    <span class="badge-user">Trenutno se izvaja</span>
                                    <br>
                                    <span class="badge-user">{{ $basic['database'] }}</span>
                                    <i class="fal fa-database black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 col-md-3">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">LARAVEL</h1>
                                    <span class="badge-user">Trenutno se izvaja</span>
                                    <br>
                                    <span class="badge-user">Ver. {{ $basic['laravel'] }}</span>
                                    <i class="fal fa-code-merge black-icon text-green"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row black-list">
                            <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">RAM</h1>
                                    <span class="badge-user">Skupno: {{ $ram['total'] }}</span>
                                    <br>
                                    <span class="badge-user">Prosto: {{ $ram['free'] }}</span>
                                    <span class="badge-user">Uporabljeno: {{ $ram['used'] }}</span>
                                    <i class="fal fa-memory black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">DISK</h1>
                                    <span class="badge-user">Skupno: {{ $disk['total'] }}</span>
                                    <br>
                                    <span class="badge-user">Prosto: {{ $disk['free'] }}</span>
                                    <span class="badge-user">Uporabljeno: {{ $disk['used'] }}</span>
                                    <i class="fal fa-hdd black-icon text-green"></i>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-4 col-md-4">
                                <div class="text-center black-item">
                                    <h1 style=" color: #ffffff;">LOAD</h1>
                                    <span class="badge-user">Povprečen: {{ $avg }}</span>
                                    <br>
                                    <span class="badge-user">Ocenjeno</span>
                                    <i class="fal fa-balance-scale-right black-icon text-green"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-10">
                <div class="block" style=" margin-top: 30px;">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <u>Dovoljenja imenika</u>
                        </h1>
                    </div>
                    <div class="panel-body">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="80%">Direktorij</th>
                                <th>CurrentSedanji</th>
                                <th>Priporočljivo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($file_permissions as $permission)
                                <tr>
                                    <td>{{ $permission['directory'] }}</td>
                                    <td>
                                        @if ($permission['permission'] == $permission['recommended'])
                                            <span class="bold text-success">
                                                    <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                                                    {{ $permission['permission'] }}
                                                </span>
                                        @else
                                            <span class="bold text-danger">
                                                    <i class="{{ config('other.font-awesome') }} fa-times-circle"></i>
                                                    {{ $permission['permission'] }}
                                                </span>
                                        @endif
                                    </td>
                                    <td>{{ $permission['recommended'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
