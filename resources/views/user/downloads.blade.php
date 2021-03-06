@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.downloads') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_downloads', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.downloads') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        @if (!auth()->user()->isAllowed($user,'torrent','show_download'))
            <div class="container pl-0 text-center">
                <div class="jumbotron shadowed">
                    <div class="container">
                        <h1 class="mt-5 text-center">
                            <i class="{{ config('other.font-awesome') }} fa-times text-danger"></i>{{ __('user.private-profile') }}
                        </h1>
                        <div class="separator"></div>
                        <p class="text-center">{{ __('user.not-authorized') }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="block">
                @include('user.buttons.public')

                @if ( $user->private_profile == 1 && auth()->user()->id != $user->id && !auth()->user()->group->is_modo )
                    <div class="container">
                        <div class="jumbotron shadowed">
                            <div class="container">
                                <h1 class="mt-5 text-center">
                                    <i
                                            class="{{ config('other.font-awesome') }} fa-times text-danger"></i>{{ __('user.private-profile') }}
                                </h1>
                                <div class="separator"></div>
                                <p class="text-center">{{ __('user.not-authorized') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div view="downloads">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered">
                                <thead>
                                <th>{{ __('torrent.name') }}</th>
                                <th>{{ __('torrent.category') }}</th>
                                <th>{{ __('torrent.size') }}</th>
                                <th>{{ __('torrent.seeders') }}</th>
                                <th>{{ __('torrent.leechers') }}</th>
                                <th>{{ __('torrent.completed') }}</th>
                                <th>{{ __('torrent.completed_at') }}</th>
                                </thead>
                                <tbody>
                                @foreach ($downloads as $download)
                                    <tr class="userFiltered" active="{{ $download->active ? '1' : '0' }}"
                                        seeding="{{ $download->seeder == 1 ? '1' : '0' }}"
                                        prewarned="{{ $download->prewarn ? '1' : '0' }}"
                                        hr="{{ $download->hitrun ? '1' : '0' }}"
                                        immune="{{ $download->immune ? '1' : '0' }}">
                                        <td>
                                            <a class="view-torrent"
                                               href="{{ route('torrent', ['id' => $download->torrent->id]) }}">
                                                {{ $download->torrent->name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $download->torrent->category->name }}
                                        </td>
                                        <td>
                                                <span class="badge-extra text-blue text-bold">
                                                    {{ $download->torrent->getSize() }}</span>
                                        </td>
                                        <td>
                                            <span class="badge-extra text-green text-bold"> {{ $download->torrent->seeders }}</span>
                                        </td>
                                        <td>
                                            <span class="badge-extra text-red text-bold"> {{ $download->torrent->leechers }}</span>
                                        </td>
                                        <td>
                                                <span class="badge-extra text-orange text-bold">
                                                    {{ $download->torrent->times_completed }} {{ __('common.times') }}</span>
                                        </td>
                                        <td>{{ $download->completed_at && $download->completed_at != null ? $download->completed_at->diffForHumans() : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{ $downloads->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
