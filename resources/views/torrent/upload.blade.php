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
        {{ __('torrent.uploads') }}
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
        <a class="nav-tab__link" href="{{ route('categories.index') }}">
            Kategorije
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('grouped') }}">
            Skupine
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('top10.index') }}">
            Top 10
        </a>
    </li>
    <li class="nav-tabV2">
        <a class="nav-tab__link" href="{{ route('rss.index') }}">
            {{ __('rss.rss') }}
        </a>
    </li>
@endsection

@section('main')
    @if ($user->can_upload == 0 || $user->group->can_upload == 0)
        <section class="panelV2">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-times text-danger"></i>
                {{ __('torrent.cant-upload') }}!
            </h2>
            <p class="panel__body">{{ __('torrent.cant-upload-desc') }}!</p>
        </section>
    @else
        <section
            class="upload panelV2"
            x-data="{
                cat: {{(int)$category_id}},
                cats: JSON.parse(atob('{!! base64_encode(json_encode($categories)) !!}'))
            }"
        >
            <h2 class="upload-title panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-file"></i>
                {{ __('torrent.torrent') }}
            </h2>
            <div class="panel__body">
                <form
                    name="upload"
                    class="upload-form form"
                    id="upload-form"
                    method="POST"
                    action="{{ route('upload') }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <p class="form__group">
                        <label for="torrent" class="form__label">Torrent {{ __('torrent.file') }}</label>
                        <input
                            class="upload-form-file form__file"
                            type="file"
                            accept=".torrent"
                            name="torrent"
                            id="torrent"
                            required
                            @change="uploadExtension.hook(); cat = $refs.catId.value"
                        >
                    </p>
                    <!--<p class="form__group">
                        <label for="nfo" class="form__label">
                            NFO {{ __('torrent.file') }} ({{ __('torrent.optional') }})
                        </label>
                        <input id="nfo" class="upload-form-file form__file" type="file" accept=".nfo" name="nfo">
                    </p>-->
                    <p class="form__group" x-show="cats[cat].type === 'no'">
                        <label for="torrent-cover" class="form__label">
                            {{ __('torrent.banner') }} {{ __('torrent.file') }} ({{ __('torrent.optional') }})
                        </label>
                        <input id="torrent-cover" class="upload-form-file form__file" type="file" accept=".jpg, .jpeg" name="torrent-cover">
                    </p>
                    <!--<p class="form__group" x-show="cats[cat].type === 'no'">
                        <label for="torrent-banner" class="form__label">
                            Banner {{ __('torrent.file') }} ({{ __('torrent.optional') }})
                        </label>
                        <input id="torrent-banner" class="upload-form-file form__file" type="file" accept=".jpg, .jpeg" name="torrent-banner">
                    </p>-->
                    <p class="form__group">
                        <input
                            type="text"
                            name="name"
                            id="title"
                            class="form__text"
                            value="{{ $title ?: old('name') }}"
                            required
                        >
                        <label class="form__label form__label--floating" for="title">{{ __('torrent.name-torrent') }}</label>
                    </p>
                    <p class="form__group">
                        <select
                            x-ref="catId"
                            name="category_id"
                            id="autocat"
                            class="form__select"
                            required
                            x-model="cat"
                            @change="cats[cat].type = cats[$event.target.value].type;"
                        >
                            <option hidden selected disabled value=""></option>
                            @foreach ($categories as $id => $category)
                                <option class="form__option" value="{{ $id }}">
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="autocat">
                            {{ __('torrent.category') }}
                        </label>
                    </p>
                    <p class="form__group">
                        <select
                            name="type_id"
                            id="autotype"
                            class="form__select"
                            required
                        >
                            <option hidden disabled selected value=""></option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected(old('type_id')==$type->id)>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="autotype">
                            {{ __('torrent.type') }}
                        </label>
                    </p>
                    <p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <select
                            name="resolution_id"
                            id="autores"
                            class="form__select"
                            x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                        >
                            <option hidden disabled selected value=""></option>
                            @foreach ($resolutions as $resolution)
                                <option value="{{ $resolution->id }}" @selected(old('resolution_id')==$resolution->id)>
                                    {{ $resolution->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="autores">
                            {{ __('torrent.resolution') }}
                        </label>
                    </p>
                    <div class="form__group--horizontal" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <p class="form__group">
                            <select
                                name="distributor_id"
                                id="autodis"
                                class="form__select"
                                x-data="{ distributor: '' }"
                                x-model="distributor"
                                x-bind:class="distributor === '' ? 'form__select--default' : ''"
                            >
                                <option hidden="" disabled selected value=""></option>
                                @foreach ($distributors as $distributor)
                                    <option value="{{ $distributor->id }}" @selected(old('distributor_id')==$distributor->id)>
                                        {{ $distributor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form__label form__label--floating" for="autodis">
                                {{ __('torrent.distributor') }} (Samo za celoten disk)
                            </label>
                        </p>
                        <p class="form__group">
                            <select
                                name="region_id"
                                id="autoreg"
                                class="form__select"
                                x-data="{ region: '' }"
                                x-model="region"
                                x-bind:class="region === '' ? 'form__select--default' : ''"
                            >
                                <option hidden disabled selected value=""></option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}" @selected(old('region_id')==$region->id)>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form__label form__label--floating" for="autoreg">
                                {{ __('torrent.region') }} (Samo za celoten disk)
                            </label>
                        </p>
                    </div>
                    <div class="form__group--horizontal" x-show="cats[cat].type === 'tv'">
                        <p class="form__group">
                            <input
                                type="text"
                                name="season_number"
                                id="season_number"
                                class="form__text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                value="{{ old('season_number') }}"
                                x-bind:required="cats[cat].type === 'tv'"
                            >
                            <label class="form__label form__label--floating" for="season_number">
                                {{ __('torrent.season-number') }}
                            </label>
                        </p>
                        <p class="form__group">
                            <input
                                type="text"
                                name="episode_number"
                                id="episode_number"
                                class="form__text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                value="{{ old('episode_number') }}"
                                x-bind:required="cats[cat].type === 'tv'"
                            >
                            <label class="form__label form__label--floating" for="episode_number">
                                {{ __('torrent.episode-number') }} (Uporabite "0" za sezonske pakete)
                            </label>
                        </p>
                    </div>
                    <div class="form__group--horizontal" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <p class="form__group">
                            <input type="hidden" name="tmdb" value="0" />
                            <input
                                type="text"
                                name="tmdb"
                                id="autotmdb"
                                class="form__text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '{{ $tmdb ?: old('tmdb') }}' : '0'"
                                x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                            >
                            <label>URL za TMDB ID: <a href="https://www.themoviedb.org/" target="_blank">https://www.themoviedb.org/</a></label>
                            <label class="form__label form__label--floating" for="autotmdb">TMDB ID</label>
                            <output name="apimatch" id="apimatch" for="torrent"></output>
                        </p>
                        <p class="form__group">
                            <input type="hidden" name="imdb" value="0" />
                            <input
                                type="text"
                                name="imdb"
                                id="autoimdb"
                                class="form__text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '{{ $imdb ?: old('imdb') }}' : '0'"
                                x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                            >
                            <label>URL za IMDB ID: <a href="https://www.imdb.com/" target="_blank">https://www.imdb.com/</a></label>
                            <label class="form__label form__label--floating" for="autoimdb">IMDB ID</label>
                        </p>
                        <p class="form__group" x-show="cats[cat].type === 'tv'">
                            <input type="hidden" name="tvdb" value="0" />
                            <input
                                type="text"
                                name="tvdb"
                                id="autotvdb"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                x-bind:value="cats[cat].type === 'tv' ? '{{ old('tvdb') }}' : '0'"
                                class="form__text"
                                x-bind:required="cats[cat].type === 'tv'"
                            >
                            <label>URL za TVDB ID: <a href="https://www.thetvdb.com/" target="_blank">https://www.thetvdb.com/</a></label>
                            <label class="form__label form__label--floating" for="autotvdb">TVDB ID</label>
                        </p>
                        <p class="form__group">
                            <input type="hidden" name="mal" value="0" />
                            <input
                                type="text"
                                name="mal"
                                id="automal"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '{{ old('mal') }}' : '0'"
                                class="form__text"
                                placeholder=""
                            >
                            <label>URL za MAL ID: <a href="https://myanimelist.net/" target="_blank">https://myanimelist.net/</a></label>
                            <label class="form__label form__label--floating" for="automal">MAL ID ({{ __('torrent.required-anime') }})</label>
                        </p>
                    </div>
                    <p class="form__group" x-show="cats[cat].type === 'game'">
                        <input
                            type="text"
                            name="igdb"
                            id="autoigdb"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            x-bind:value="cats[cat].type === 'game' ? '{{ old('igdb') }}' : '0'"
                            class="form__text"
                            x-bind:required="cats[cat].type === 'game'"
                        >
                        <label>URL za IGDB ID: <a href="https://www.igdb.com/discover" target="_blank">https://www.igdb.com/discover</a></label>
                        <label class="form__label form__label--floating" for="autoigdb">IGDB ID <b>({{ __('torrent.required-games') }})</b></label>
                    </p>
                    <p class="form__group">
                        <input
                            type="text"
                            name="keywords"
                            id="autokeywords"
                            class="form__text"
                            value="{{ old('keywords') }}"
                            placeholder=""
                        >
                        <label class="form__label form__label--floating" for="autokeywords">
                            {{ __('torrent.keywords') }} (<i>{{ __('torrent.keywords-example') }}</i>)
                        </label>
                    </p>
                    @livewire('bbcode-input', ['name' => 'description', 'label' => __('common.description') ])
                    <!--<p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <textarea
                            id="upload-form-mediainfo"
                            name="mediainfo"
                            class="form__textarea"
                            placeholder=""
                        >{{ old('mediainfo') }}</textarea>
                        <label class="form__label form__label--floating" for="upload-form-mediainfo">
                            {{ __('torrent.media-info-parser') }}
                        </label>
                    </p>-->
                    <!--<p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <textarea
                            id="upload-form-bdinfo"
                            name="bdinfo"
                            class="form__textarea"
                            placeholder=""
                        >{{ old('bdinfo') }}</textarea>
                        <label class="form__label form__label--floating" for="upload-form-bdinfo">
                            BDInfo (Quick Summary)
                        </label>
                    </p>-->
                    <p class="form__group">
                        <input type="hidden" name="anonymous" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="anonymous"
                            name="anonymous"
                            value="1"
                            @checked(old('anonymous'))
                        >
                        <label for="anonymous">{{ __('common.anonymous') }}?</label>
                    </p>
                    <p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <input type="hidden" name="stream" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="stream"
                            name="stream"
                            x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '1' : '0'"
                            @checked(old('stream'))
                        >
                        <label for="stream">{{ __('torrent.stream-optimized') }}?</label>
                    </p>
                    <p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv'">
                        <input type="hidden" name="sd" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="sd"
                            name="sd"
                            x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'tv') ? '1' : '0'""
                            @checked(old('sd'))
                        >
                        <label for="sd">{{ __('torrent.sd-content') }}?</label>
                    </p>
                    @if (auth()->user()->group->is_modo || auth()->user()->group->is_internal)
                        <p class="form__group">
                            <input type="hidden" name="internal" value="0">
                            <input
                                type="checkbox"
                                class="form__checkbox"
                                id="internal"
                                name="internal"
                                value="1"
                                @checked(old('internal'))
                            >
                            <label for="internal">{{ __('torrent.internal') }}?</label>
                        </p>
                    @else
                        <input type="hidden" name="internal" value="0">
                    @endif
                    <p class="form__group">
                        <input type="hidden" name="personal_release" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="personal_release"
                            name="personal_release"
                            value="1"
                            @checked(old('personal_release'))
                        >
                        <label for="personal_release">Personal Release?</label>
                    </p>
                    @if (auth()->user()->group->is_modo || auth()->user()->group->is_internal)
                        <p class="form__group">
                            <select name="free" id="free" class="form__select">
                                <option value="0" @selected(old('free') === '0' || old('free') === null)>{{ __('common.no') }}</option>
                                <option value="25" @selected(old('free') === '25')>25%</option>
                                <option value="50" @selected(old('free') === '50')>50%</option>
                                <option value="75" @selected(old('free') === '75')>75%</option>
                                <option value="100" @selected(old('free') === '100')>100%</option>
                            </select>
                            <label class="form__label form__label--floating" for="free">
                                {{ __('torrent.freeleech') }}
                            </label>
                        </p>
                    @else
                        <input type="hidden" name="free" value="0" />
                    @endif
                    <p class="form__group">
                        <button type="submit" class="form__button form__button--filled" name="post" value="true" id="post" class="btn btn-success">
                            {{ __('torrent.button') }}
                        </button>
                    </p>
                    <br>
                </form>
            </div>
        </section>
    @endif
@endsection

@if ($user->can_upload == 1 && $user->group->can_upload == 1)
    @section('sidebar')
        <section class="panelV2">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-info"></i>
                {{ __('common.info') }}
            </h2>
            <div class="panel__body">
                <!--<p>{{ __('torrent.announce-url') }}:
                    <a href="{{ route('announce', ['passkey' => $user->passkey]) }}">
                        {{ route('announce', ['passkey' => $user->passkey]) }}
                    </a>
                </p>
                <br>
                <p>{{ __('torrent.announce-url-desc', ['source' => config('torrent.source')]) }}</p>
                <br>-->
                <p class="text-success">{!! __('torrent.announce-url-desc-url', ['url' => route('instructions')]) !!}</p>
            </div>
        </section>
    @endsection
@endif

@section('javascripts')
    <script src="{{ mix('js/imgbb.js') }}" crossorigin="anonymous"></script>
@endsection
