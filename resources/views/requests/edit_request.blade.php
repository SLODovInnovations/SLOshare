@extends('layout.default')

@section('title')
    <title>{{ __('request.edit-request') }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('requests.index') }}" class="breadcrumb__link">
            {{ __('request.requests') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('request', ['id' => $torrentRequest->id]) }}" class="breadcrumb__link">
            {{ $torrentRequest->name }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.edit') }}
    </li>
@endsection

@section('content')
    <div class="container">
        @if ($user->can_request == 0)
            <div class="container">
                <div class="jumbotron shadowed">
                    <div class="container">
                        <h1 class="mt-5 text-center">
                            <i class="{{ config('other.font-awesome') }} fa-times text-danger"></i>
                            {{ __('request.no-privileges') }}
                        </h1>
                        <div class="separator"></div>
                        <p class="text-center">{{ __('request.no-privileges-desc') }}!</p>
                    </div>
                </div>
            </div>
        @else
            <h1 class="upload-title">{{ __('request.edit-request') }}</h1>
            <form role="form" method="POST" action="{{ route('edit_request', ['id' => $torrentRequest->id]) }}">
                @csrf
                <div class="block">
                    <div class="form-group">
                        <label for="name">{{ __('request.title') }}</label>
                        <label>
                            <input type="text" name="name" class="form-control" value="{{ $torrentRequest->name }}"
                                   required>
                        </label>
                    </div>

                    @if ($torrentRequest->category->movie_meta || $torrentRequest->category->tv_meta || $torrentRequest->category->cartoon_meta)
                        <div class="form-group">
                            <label for="name">TMDB ID <b>({{ __('common.required') }} za FILME, SERIJE in RISANKE)</b></label>
                            <br>
                            <label for="name">URL za TMDB ID: <a href="https://www.themoviedb.org/" target="_blank"><b>https://www.themoviedb.org/</b></a></label>
                            <label>
                                <input type="number" name="tmdb" value="{{ $torrentRequest->tmdb }}"
                                       class="form-control" required>
                            </label>
                        </div>
                    @else
                        <input type="hidden" name="tmdb" value="0">
                    @endif

                    @if ($torrentRequest->category->movie_meta || $torrentRequest->category->tv_meta || $torrentRequest->category->cartoon_meta)
                        <div class="form-group">
                            <label for="name">IMDB ID <b>({{ __('torrent.optional') }})</b></label>
                            <br>
                            <label for="name">URL za IMDB ID: <a href="https://www.imdb.com/" target="_blank"><b>https://www.imdb.com/</b></a></label>
                            <label>
                                <input type="number" name="imdb" value="{{ $torrentRequest->imdb }}"
                                       class="form-control" required>
                            </label>
                        </div>
                    @else
                        <input type="hidden" name="imdb" value="0">
                    @endif

                    @if ($torrentRequest->category->tv_meta)
                        <div class="form-group">
                            <label for="name">TVDB ID <b>({{ __('torrent.optional') }})</b></label>
                            <br>
                            <label for="name">URL za TVDB ID: <a href="https://www.thetvdb.com/" target="_blank"><b>https://www.thetvdb.com/</b></a></label>
                            <label>
                                <input type="number" name="tvdb" value="{{ $torrentRequest->tvdb }}"
                                       class="form-control" required>
                            </label>
                        </div>
                    @else
                        <input type="hidden" name="tvdb" value="0">
                    @endif

                    @if ($torrentRequest->category->movie_meta || $torrentRequest->category->tv_meta || $torrentRequest->category->cartoon_meta)
                        <div class="form-group">
                            <label for="name">MAL ID <b>({{ __('request.required') }} For Anime)</b></label>
                            <label>
                                <input type="number" name="mal" value="{{ $torrentRequest->mal }}" class="form-control"
                                       required>
                            </label>
                        </div>
                    @else
                        <input type="hidden" name="mal" value="0">
                    @endif

                    @if ($torrentRequest->category->game_meta)
                        <div class="form-group">
                            <label for="name">IGDB ID <b>{{ __('request.required') }} za IGRE))</b></label>
                            <br>
                            <label for="name">URL za IGDB ID: <a href="https://www.igdb.com/discover" target="_blank"><b>https://www.igdb.com/discover</b></a></label>
                            <label>
                                <input type="number" name="igdb" value="{{ $torrentRequest->igdb }}"
                                       class="form-control" required>
                            </label>
                        </div>
                    @else
                        <input type="hidden" name="igdb" value="0">
                    @endif

                    <div class="form-group">
                        <label for="category_id">{{ __('request.category') }}</label>
                        <label>
                            <select name="category_id" class="form-control">
                                <option value="{{ $torrentRequest->category->id }}" selected>
                                    {{ $torrentRequest->category->name }} ({{ __('request.current') }})
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="type">{{ __('request.type') }}</label>
                        <label>
                            <select name="type_id" class="form-control">
                                <option value="{{ $torrentRequest->type->id }}"
                                        selected>{{ $torrentRequest->type->name }}
                                    ({{ __('request.current') }})
                                </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    @if ($torrentRequest->category->movie_meta || $torrentRequest->category->tv_meta || $torrentRequest->category->cartoon_meta)
                        <div class="form-group">
                            <label for="resolution_id">{{ __('torrent.resolution') }}</label>
                            <label>
                                <select name="resolution_id" class="form-control">
                                    @if (! $torrentRequest->resolution)
                                        <option hidden="" disabled="disabled" selected="selected" value="">{{ __('request.select-resolution') }}
                                        </option>)
                                    @else
                                        <option value="{{ $torrentRequest->resolution->id }}"
                                                selected>{{ $torrentRequest->resolution->name }}
                                            ({{ __('request.current') }})
                                        </option>
                                    @endif
                                    @foreach ($resolutions as $resolution)
                                        <option value="{{ $resolution->id }}">{{ $resolution->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="description">{{ __('request.description') }}</label>
                        <label for="request-form-description"></label>
                        <textarea id="request-form-description" name="description" cols="30" rows="10"
                                  class="form-control">{{ $torrentRequest->description }}</textarea>
                    </div>

                    <br>

@if (auth()->user()->group->is_admin)
                    <label for="anon" class="control-label">{{ __('common.anonymous') }}?</label>
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="anon" @if ($torrentRequest->anon == 1) checked @endif
                            value="1">{{ __('common.yes') }}
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="anon" @if ($torrentRequest->anon == 0) checked @endif
                            value="0">{{ __('common.no') }}
                        </label>
                    </div>
@else
                    <input type="hidden" name="anon" value="0">
@endif

                    <br>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
                    </div>
                </div>
            </form>
    </div>
    @endif
@endsection

@section('javascripts')
    <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(document).ready(function () {
        $('#request-form-description').wysibb({})
      })

    </script>
@endsection
