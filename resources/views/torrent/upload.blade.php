@extends('layout.default')

@section('title')
    <title>{{ __('torrent.uploads') }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('torrents') }}" class="breadcrumb__link">
            {{ __('torrent.torrents') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.upload') }}
    </li>
@endsection

@section('nav-tabs')
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('torrents') }}">
            Seznam
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('cards') }}">
            Kartice
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('categories') }}">
            Kategorije
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('grouped') }}">
            Skupine
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab--active__link" href="{{ route('top10.index') }}">
            Top 10
        </a>
    </li>
    <li class="nav-tab--active">
        <a class="nav-tab__link" href="{{ route('rss.index') }}">
            {{ __('rss.rss') }}
        </a>
    </li>
    <li class="nav-tab--active">
        <a class="nav-tab__link" href="{{ route('upload_form', ['category_id' => 1]) }}">
            {{ __('common.upload') }}
        </a>
    </li>
@endsection

@section('content')
    @if ($user->can_upload == 0 || $user->group->can_upload == 0)
        <div class="container">
            <div class="jumbotron shadowed">
                <div class="container">
                    <h1 class="mt-5 text-center">
                        <i class="{{ config('other.font-awesome') }} fa-times text-danger"></i> {{ __('torrent.cant-upload') }}
                        !
                    </h1>
                    <div class="separator"></div>
                    <p class="text-center">{{ __('torrent.cant-upload-desc') }}!</p>
                </div>
            </div>
        </div>
    @else
        <div class="torrent box container" id="preview-box" style="display:none">
            <h2 class="text-center mt-10">{{ __('torrent.upload-description') }}</h2>
            <div class="preview col-md-12" id="preview-content"></div>
        </div>
        <div class="torrent box container">
            <!--<div class="alert alert-info text-center">
                <h2 class="mt-10"><strong>{{ __('torrent.announce-url') }}:</strong>
                    {{ route('announce', ['passkey' => $user->passkey]) }}
                </h2>
                <p>{{ __('torrent.announce-url-desc', ['source' => config('torrent.source')]) }}.</p>
            </div>-->
            <br>
            <div class="alert alert-info text-center">
                <p class="text-success" style="color:#ffffff;">{{ __('torrent.announce-url-desc-url') }}
                <a href="{{ route('instructions') }}" style="color:#ffffff;">TUKAJ</a>
                </p>
            </div>

            <div class="upload col-md-12"
                 x-data="{
                 cat: {{(int)$category_id}},
                 cats: JSON.parse(atob('{!! base64_encode(json_encode($categories)) !!}'))}">
                <h2 class="upload-title">{{ __('torrent.torrent') }}</h2>
                <form name="upload" class="upload-form" id="upload-form" method="POST" action="{{ route('upload') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="torrent">Torrent {{ __('torrent.file') }}</label>
                            <input class="upload-form-file" type="file" accept=".torrent" name="torrent" id="torrent"
                               required @change="uploadExtension.hook(); cat = $refs.catId.value">
                        </div>
                    </div>

                    <!--<div class="form-group">
                        <label for="nfo">NFO {{ __('torrent.file') }} ({{ __('torrent.optional') }})</label>
                        <input class="upload-form-file" type="file" accept=".nfo" name="nfo">
                    </div>-->

                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group" x-show="cats[cat].type === 'no'">
                                <label for="torrent-cover">{{ __('torrent.banner') }}</label>
                                <input class="upload-form-file" type="file" accept=".jpg, .jpeg" name="torrent-cover">
                            </div>
                        </div>

                    <div class="form-group">
                        <label for="name">{{ __('torrent.name-torrent') }}</label>
                        <label for="title"></label>
                        <input type="text" name="name" id="title" class="form-control"
                               value="{{ !empty($title) ? $title : old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">{{ __('torrent.category') }}</label>
                        <label>
                            <select x-ref="catId" name="category_id" id="autocat" class="form-control" required x-model="cat" @change="cats[cat].type = cats[$event.target.value].type;">
                                <option hidden="" disabled="disabled" value="">{{ __('torrent.select-category') }}
                                </option>
                                @foreach ($categories as $id => $category)
                                    <option value="{{ $id }}">
                                        {{ $category['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="type_id">{{ __('torrent.type') }}</label>
                        <label>
                            <select name="type_id" id="autotype" class="form-control" required>
                                <option hidden="" disabled="disabled" selected="selected" value="">{{ __('torrent.select-type') }}
                                </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                            @if (old('type_id')==$type->id) selected="selected"@endif>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label for="resolution_ids">{{ __('torrent.resolution') }}</label>
                        <label>
                            <select name="resolution_id" id="autores" class="form-control">
                                <option hidden="" disabled="disabled" selected="selected" value="">{{ __('torrent.select-resolution') }}
                                </option>
                                @foreach ($resolutions as $resolution)
                                    <option value="{{ $resolution->id }}"
                                            @if (old('resolution_id')==$resolution->id) selected="selected" @endif>
                                        {{ $resolution->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label for="distributor_id">{{ __('torrent.distributor') }} (Samo za celoten disk)</label>
                        <label>
                            <select name="distributor_id" id="autodis" class="form-control">
                                <option hidden="" disabled="disabled" selected="selected" value="">{{ __('torrent.select-distributor') }}
                                </option>
                                @foreach ($distributors as $distributor)
                                    <option value="{{ $distributor->id }}"
                                            @if (old('distributor_id')==$distributor->id) selected="selected" @endif>
                                        {{ $distributor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label for="region_id">{{ __('torrent.region') }} (Samo za celoten disk)</label>
                        <label>
                            <select name="region_id" id="autoreg" class="form-control">
                                <option hidden="" disabled="disabled" selected="selected" value="">{{ __('torrent.select-region') }}
                                </option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}"
                                            @if (old('region_id')==$region->id) selected="selected" @endif>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'tv'">
                        <label for="season_number">{{ __('torrent.season-number') }} <b>({{ __('request.required') }} za
                                TV)</b></label>
                        <label>
                            <input type="number" name="season_number" id="season_number" class="form-control"
                                    value="{{ old('season_number') ?? '0' }}" required>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'tv'">
                        <label for="episode_number">{{ __('torrent.episode-number') }} <b>({{ __('request.required') }} za
                                TV. Uporabite "0" za sezonske pakete.)</b></label>
                        <label>
                            <input type="number" name="episode_number" id="episode_number" class="form-control"
                                    value="{{ old('episode_number') ?? '0' }}" required>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label for="name">TMDB ID <b>({{ __('request.required') }})</b></label>
                        <br>
                        <label for="name">URL za TMDB ID: <a href="https://www.themoviedb.org/" target="_blank"><b>https://www.themoviedb.org/</b></a></label>
                        <label>
                            <input type="text" name="apimatch" id="apimatch" class="form-control" value="" disabled>
                            <input type="number" name="tmdb" id="autotmdb" class="form-control"
                                    x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '{{ !empty($tmdb) ? $tmdb : old('tmdb') }}' : '0'" required>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label for="name">IMDB ID <b>({{ __('torrent.optional') }})</b></label>
                        <br>
                        <label for="name">URL za IMDB ID: <a href="https://www.imdb.com/" target="_blank"><b>https://www.imdb.com/</b></a></label>
                        <label>
                            @php $imdb_val = 0;
                            if (!empty($imdb)) {
                                $imdb_val = $imdb;
                            }
                            if (!empty(old('imdb'))) {
                                $imdb_val = old('imdb');
                            } @endphp
                            <input type="number" name="imdb" id="autoimdb" class="form-control"
                                x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '{{ $imdb_val }}' : '0'">
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'tv'">
                        <label for="name">TVDB ID ({{ __('torrent.optional') }})</label>
                        <br>
                        <label for="name">URL za TVDB ID: <a href="https://www.thetvdb.com/" target="_blank"><b>https://www.thetvdb.com/</b></a></label>
                        <label>
                            <input type="number" name="tvdb" id="autotvdb"
                                    :value="cats[cat].type === 'tv' ? '{{ old('tvdb') ?? '0' }}' : '0'"
                                    class="form-control" required>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label for="name">MAL ID ({{ __('torrent.required-anime') }})</label>
                        <br>
                        <label for="name">URL za MAL ID: <a href="https://myanimelist.net/" target="_blank"><b>https://myanimelist.net/</b></a></label>
                        <label>
                            <input type="number" name="mal" x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '{{ old('mal') ?? '0' }}' : '0'" class="form-control"
                                    required>
                        </label>
                    </div>

                    <div class="form-group" x-show="cats[cat].type === 'game'">
                        <label for="name">IGDB ID <b>({{ __('torrent.required-games') }})</b></label>
                        <br>
                        <label for="name">URL za IGDB ID: <a href="https://www.igdb.com/discover" target="_blank"><b>https://www.igdb.com/discover</b></a></label>
                        <label>
                            <input type="number" name="igdb" x-bind:value="cats[cat].type === 'game' ? '{{ old('igdb') ?? '0' }}' : '0'" class="form-control"
                                    required>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('torrent.keywords') }} (<i>{{ __('torrent.keywords-example') }}</i>)</label>
                        <label>
                            <input type="text" name="keywords" id="autokeywords" class="form-control"
                                   value="{{ old('keywords') }}">
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('torrent.description') }}</label>
                        <label for="upload-form-description"></label>
                        <textarea id="upload-form-description" name="description" cols="30" rows="10"
                                  class="form-control">{{ old('description') }}</textarea>
                    </div>


                    <!--    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                            <label for="mediainfo">{{ __('torrent.media-info-parser') }}</label>
                            <label for="upload-form-description"></label>
                            <textarea id="upload-form-description" name="mediainfo" cols="30" rows="10"
                                      class="form-control"
                                      placeholder="{{ __('torrent.media-info-paste') }}">{{ old('mediainfo') }}</textarea>
                        </div>-->

                    <!--    <div class="form-group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                            <label for="bdinfo">BDInfo (Quick Summary)</label>
                            <label for="upload-form-description"></label>
                            <textarea id="upload-form-description" name="bdinfo" cols="30" rows="10"
                                      class="form-control"
                                      placeholder="Paste BDInfo Quick Summary">{{ old('bdinfo') }}</textarea>
                        </div>-->

@if (auth()->user()->group->is_admin)
                    <label for="anonymous" class="control-label">{{ __('common.anonymous') }}?</label>
                    <div class="radio-inline">
                        <label><input type="radio" name="anonymous"
                                      value="1"{{ old('anonymous') ? ' checked' : '' }}>{{ __('common.yes') }}</label>
                    </div>
                    <div class="radio-inline">
                        <label><input type="radio" name="anonymous"
                                      value="0"{{ !old('anonymous') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                    </div>
@else
                    <input type="hidden" name="anonymous" value="0">
@endif

@if (auth()->user()->group->is_admin)
                    <br x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">

                    <label for="stream" class="control-label" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">{{ __('torrent.stream-optimized') }}?</label>
                    <div class="radio-inline" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label><input type="radio" name="stream" id="stream"
                                        value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '1' : '0'"{{ old('stream') ? ' checked' : '' }}>{{ __('common.yes') }}</label>
                    </div>
                    <div class="radio-inline" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label><input type="radio" name="stream" id="stream"
                                        value="0"{{ !old('stream') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                    </div>
@else
                    <input type="hidden" name="stream" value="0">
@endif

@if (auth()->user()->group->is_admin)

                    <br x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">

                    <label for="sd" class="control-label" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">{{ __('torrent.sd-content') }}?</label>
                    <div class="radio-inline" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label><input type="radio" name="sd"
                                        x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '1' : '0'"{{ old('sd') ? ' checked' : '' }}>{{ __('common.yes') }}</label>
                    </div>
                    <div class="radio-inline" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <label><input type="radio" name="sd"
                                        value="0"{{ !old('sd') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                    </div>
@else
                    <input type="hidden" name="sd" value="0">
@endif
                    <br>

                    @if (auth()->user()->group->is_admin || auth()->user()->group->is_internal)
                        <label for="internal" class="control-label">{{ __('torrent.internal') }}?</label>
                        <div class="radio-inline">
                            <label><input type="radio" name="internal"
                                          value="1"{{ old('internal') ? ' checked' : '' }}>{{ __('common.yes') }}</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="internal"
                                          value="0"{{ !old('internal') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                        </div>

                        <br>
                    @else
                        <input type="hidden" name="internal" value="0">
                    @endif

@if (auth()->user()->group->is_admin)
                    <label for="personal_release" class="control-label">Personal Release?</label>
                    <div class="radio-inline">
                        <label><input type="radio" name="personal_release"
                                      value="1"{{ old('personal_release') ? ' checked' : '' }}>{{ __('common.yes') }}
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label><input type="radio" name="personal_release"
                                      value="0"{{ !old('personal_release') ? ' checked' : '' }}>{{ __('common.no') }}
                        </label>
                    </div>
                    <br>
@else
                        <input type="hidden" name="personal_release" value="0">
@endif

                    @if (auth()->user()->group->is_freeleech)
                        <label for="freeleech" class="control-label">{{ __('torrent.freeleech') }}?</label>
                        <div class="radio-inline">
                            <label><input type="radio" name="free"
                                          value="100"{{ old('free') ? ' checked' : '' }}>100%</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="free"
                                          value="75"{{ old('free') ? ' checked' : '' }}>75%</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="free"
                                          value="50"{{ old('free') ? ' checked' : '' }}>50%</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="free"
                                          value="25"{{ old('free') ? ' checked' : '' }}>25%</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="free"
                                          value="0"{{ !old('free') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                        </div>
                    @else
                        <input type="hidden" name="free" value="0">
                    @endif

                    <div class="text-center">
                        <button type="button" name="preview" value="true" id="preview" class="btn btn-info">
                            {{ __('common.preview') }}
                        </button>
                        <button type="submit" name="post" value="true" id="post" class="btn btn-success">
                            {{ __('torrent.button') }}
                        </button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    @endif
@endsection

@section('javascripts')
    <script src="{{ mix('js/imgbb.js') }}" crossorigin="anonymous"></script>
    <script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
      $('#preview').on('click', function () {
        var text = $('#upload-form-description').bbcode().trim()

        if (text.length > 0) {
          $.post('/upload/preview', {
            'description': text
          }, function (data) {
            document.getElementById('preview-content').innerHTML = data
            document.getElementById('preview-box').removeAttribute('style')
            document.getElementById('main-content').scrollIntoView({ behavior: 'smooth' })
          })
        }
      })
    </script>
@endsection
