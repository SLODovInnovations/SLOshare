@extends('layout.default')

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('torrents') }}" class="breadcrumb__link">
            {{ __('torrent.torrents') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('torrent', ['id' => $torrent->id]) }}" class="breadcrumb__link">
            {{ $torrent->name }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.edit') }}
    </li>
@endsection

@section('main')
    <section
        class="panelV2"
        x-data="{
            cat: {{(int)$torrent->category_id}},
            cats: JSON.parse(atob('{!! base64_encode(json_encode($categories)) !!}')),
            type: {{ (int)$torrent->type_id }},
            types: JSON.parse(atob('{!! base64_encode(json_encode($types)) !!}'))
        }"
    >
        <h2 class="panel__heading">{{ __('common.edit') }}: {{ $torrent->name }}</h2>
        <div class="panel__body">
            <form
                class="form"
                method="POST"
                action="{{ route('edit', ['id' => $torrent->id]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'tv' || cats[cat].type === 'cartoon' || cats[cat].type === 'cartoontv' || cats[cat].type === 'music' || cats[cat].type === 'no'">
                    <label class="form__label" for="torrent-cover">
                        {{ __('torrent.banner') }} {{ __('torrent.file') }} ({{ __('torrent.optional') }})
                    </label>
                    <input
                        id="torrent-cover"
                        class="form__file"
                        accept=".jpg, .jpeg, .png"
                        name="torrent-cover"
                        type="file"
                    >
                </p>
                <!--<p class="form__group" x-show="cats[cat].type === 'no'">
                    <label class="form__label" for="torrent-banner">
                        Banner {{ __('torrent.file') }} ({{ __('torrent.optional') }})
                    </label>
                    <input
                        id="torrent-banner"
                        class="form__file"
                        accept=".jpg, .jpeg, .png"
                        name="torrent-banner"
                        type="file"
                    >
                </p>-->
                <p class="form__group">
                    <input type="text" class="form__text" name="name" value="{{ old('name') ?? $torrent->name }}" required>
                    <label class="form__label form__label--floating" for="name">
                        {{ __('torrent.title') }}
                    </label>
                </p>
                <p class="form__group">
                    <select
                        id="category_id"
                        class="form__select"
                        name="category_id"
                        x-model="cat"
                        x-ref="catId"
                        @change="cats[cat].type = cats[$event.target.value].type;"
                    >
                        <option value="{{ old('category_id') ?? $torrent->category_id }}" selected>
                            {{ $torrent->category->name }} ({{ __('torrent.current') }})
                        </option>
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}" @selected('category_id' === $id)>
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <label class="form__label form__label--floating" for="category_id">
                        {{ __('torrent.category') }}
                    </label>
                </p>
                <p class="form__group">
                    <select
                        id="type_id"
                        class="form__select"
                        name="type_id"
                        x-model="type"
                        x-ref="typeId"
                        @change="types[type].name = types[$event.target.value].name"
                    >
                        <option value="{{ old('type_id') ?? $torrent->type->id }}" selected>
                            {{ $torrent->type->name }} ({{ __('torrent.current') }})
                        </option>
                        @foreach ($types as $id => $type)
                            <option value="{{ $id }}" @selected(old('type_id') === $id)>
                                {{ $type['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <label class="form__label form__label--floating" for="type_id">
                        {{ __('torrent.type') }}
                    </label>
                </p>
                <p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'">
                    <select id="resolution_id" name="resolution_id" class="form__select">
                        @if (! $torrent->resolution)
                            <option hidden="" disabled="disabled" selected="selected" value="">
                                {{ __('torrent.resolution') }}
                            </option>)
                        @else
                            <option value="{{ old('resolution_id') ?? $torrent->resolution->id }}" selected>
                                {{ $torrent->resolution->name }} ({{ __('torrent.current') }})
                            </option>
                        @endif
                        @foreach ($resolutions as $resolution)
                            <option value="{{ $resolution->id }}" @selected(old('resolution_id') === $resolution->id)>
                                {{ $resolution->name }}
                            </option>
                        @endforeach
                    </select>
                    <label class="form__label form__label--floating" for="resolution_id">
                        {{ __('torrent.resolution') }}
                    </label>
                </p>
                <div class="form__group--horizontal" x-show="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') && types[type].name === 'Full Disc'">
                    <p class="form__group">
                        <select id="distributor_id" name="distributor_id" class="form__select">
                            @if (! $torrent->distributor)
                                <option hidden="" disabled="disabled" selected="selected" value="">
                                    {{ __('torrent.select-distributor') }}
                                </option>)
                            @else
                                <option
                                    x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') && types[type].name === 'Full Disc' ? '{{ $torrent->distributor->id }}' : ''"
                                    selected
                                >
                                    {{ $torrent->distributor->name }} ({{ __('torrent.current') }})
                                </option>
                            @endif
                            <option value="">Brez distributerja</option>
                            @foreach ($distributors as $distributor)
                                <option
                                    x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') && types[type].name === 'Full Disc' ? '{{ $distributor->id }}' : ''"
                                    value="{{ $distributor->id }}"
                                    @selected(old('distributor_id') === $distributor->id)
                                >
                                    {{ $distributor->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="distributor_id">
                            {{ __('torrent.distributor') }}
                        </label>
                    </p>
                    <p class="form__group">
                        <select id="region_id" name="region_id" class="form__select">
                            @if (! $torrent->region)
                                <option hidden="" disabled="disabled" selected="selected" value="">
                                    {{ __('torrent.select-region') }}
                                </option>)
                            @else
                                <option
                                    x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') && types[type].name === 'Full Disc' ? '{{ $torrent->region->id }}' : ''"
                                    selected
                                >
                                    {{ $torrent->region->name }} ({{ __('torrent.current') }})
                                </option>
                            @endif
                            <option value="">Brez regije</option>
                            @foreach ($regions as $region)
                                <option
                                    x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') && types[type].name === 'Full Disc' ? '{{ $region->id }}' : ''"
                                    @selected(old('region_id') === $region->id)
                                >
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form__label form__label--floating" for="region_id">
                            {{ __('torrent.region') }}
                        </label>
                    </p>
                </div>
                <div class="form__group--horizontal" x-show="cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'">
                    <p class="form__group">
                        <input
                            id="season_number"
                            class="form__text"
                            inputmode="numeric"
                            name="season_number"
                            pattern="[0-9]*"
                            x-bind:required="cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'"
                            type="text"
                            value="{{ old('season_number') ?? $torrent->season_number }}"
                        >
                        <label class="form__label form__label--floating" for="season_number">
                            {{ __('torrent.season-number') }}
                        </label>
                    </p>
                    <p class="form__group">
                        <input
                            id="episode_number"
                            class="form__text"
                            inputmode="numeric"
                            name="episode_number"
                            pattern="[0-9]*"
                            x-bind:required="cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'"
                            type="text"
                            value="{{ old('episode_number') ?? $torrent->episode_number }}"
                        >
                        <label class="form__label form__label--floating" for="episode_number">
                            {{ __('torrent.episode-number') }} (Uporabite "0" za sezonske pakete)
                        </label>
                    </p>
                </div>
                <div class="form__group--horizontal" x-show="cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'">
                    <p class="form__group">
                        <input type="hidden" name="tmdb" value="0">
                        <input
                            id="tmdb"
                            class="form__text"
                            inputmode="numeric"
                            name="tmdb"
                            pattern="[0-9]*"
                            type="text"
                            value="{{ old('tmdb') ?? $torrent->tmdb }}"
                            x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') ? '{{ old('tmdb') ?? $torrent->tmdb }}' : '0'"
                            x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'"
                        >
                        <label class="form__label form__label--floating" for="tmdb">TMDB ID</label>
                    </p>
                    <p class="form__group">
                        <input type="hidden" name="imdb" value="0">
                        <input
                            id="imdb"
                            class="form__text"
                            inputmode="numeric"
                            name="imdb"
                            pattern="[0-9]*"
                            type="text"
                            value="{{ old('imdb') ?? $torrent->imdb }}"
                            x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') ? '{{ old('imdb') ?? $torrent->imdb }}' : '0'"
                            x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'tv'"
                        >
                        <label class="form__label form__label--floating" for="imdb">IMDB ID</label>
                    </p>
                    <p class="form__group" x-show="cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'">
                        <input type="hidden" name="tvdb" value="0">
                        <input
                            id="tvdb"
                            class="form__text"
                            inputmode="numeric"
                            name="tvdb"
                            pattern="[0-9]*"
                            type="text"
                            value="{{ old('tvdb') ?? $torrent->tvdb }}"
                            x-bind:value="(cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') ? '{{ old('tvdb') ?? $torrent->tvdb }}' : '0'"
                            x-bind:required="cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'"
                        >
                        <label class="form__label form__label--floating" for="tvdb">TVDB ID</label>
                    </p>
                    <!--<p class="form__group">
                        <input type="hidden" name="mal" value="0">
                        <input
                            id="mal"
                            class="form__text"
                            inputmode="numeric"
                            name="mal"
                            pattern="[0-9]*"
                            type="text"
                            value="{{ old('mal') ?? $torrent->mal }}"
                            x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') ? '{{ old('mal') ?? $torrent->mal }}' : '0'"
                            x-bind:required="cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'"
                        >
                        <label class="form__label form__label--floating" for="mal">MAL ID <b>({{ __('torrent.required-anime') }})</b></label>
                    </p>-->
                    <input type="hidden" name="mal" value="0">
                </div>
                <p class="form__group" x-show="cats[cat].type === 'game'">
                    <input type="hidden" name="igdb" value="0">
                    <input
                        id="igdb"
                        class="form__text"
                        name="igdb"
                        type="text"
                        value="{{ old('igdb') ?? $torrent->igdb }}"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        x-bind:value="cats[cat].type === 'game' ? '{{ old('igdb') ?? $torrent->igdb }}' : '0'"
                        x-bind:required="cats[cat].type === 'game'"
                    >
                    <label class="form__label form__label--floating" for="igdb">IGDB ID <b>({{ __('torrent.required-games') }})</b></label>
                </p>
                <p class="form__group">
                    <input
                        id="keywords"
                        class="form__text"
                        name="keywords"
                        type="text"
                        placeholder=""
                        value="{{ old('keywords') ?? $keywords->implode(', ') }}"
                    >
                    <label class="form__label form__label--floating" for="keywords">
                        {{ __('torrent.keywords') }} (<i>{{ __('torrent.keywords-example') }}</i>)
                    </label>
                </p>
                @livewire('bbcode-input', [
                    'name'     => 'description',
                    'label'    => __('common.description'),
                    'required' => true,
                    'content'  => $torrent->description
                ])
                <!--<p class="form__group">
                    <textarea
                        id="description"
                        class="form__textarea"
                        name="mediainfo"
                        placeholder=""
                    >{{ old('mediainfo') ?? $torrent->mediainfo }}</textarea>
                    <label class="form__label form__label--floating" for="description">
                        {{ __('torrent.media-info') }}
                    </label>
                </p>-->

                <!--<p class="form__group">
                    <textarea
                        id="bdinfo"
                        class="form__textarea"
                        name="bdinfo"
                        placeholder=""
                    >{{ old('bdinfo') ?? $torrent->bdinfo }}</textarea>
                    <label class="form__label form__label--floating" for="description">
                        BDInfo (Quick Summary)
                    </label>
                </p>-->

                <!--@if (auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                    <p class="form__group">
                        <input type="hidden" name="anonymous" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="anonymous"
                            name="anonymous"
                            value="1"
                            @checked(old('anonymous') ?? $torrent->anon)
                        >
                        <label class="form__label" for="anonymous">{{ __('common.anonymous') }}?</label>
                    </p>
                @else
                    <input type="hidden" name="anonymous" value={{ $torrent->anon }}>
                @endif-->
                <input type="hidden" name="anonymous" value="0">
                <!--<p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'">
                    <input type="hidden" name="stream" value="0">
                    <input
                        type="checkbox"
                        class="form__checkbox"
                        id="stream"
                        name="stream"
                        x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') ? '1' : '0'"
                        @checked(old('stream') ?? $torrent->stream)
                    >
                    <label class="form__label" for="stream">{{ __('torrent.stream-optimized') }}?</label>
                </p>-->
                <input type="hidden" name="stream" value="0">
                <!--<p class="form__group" x-show="cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv'">
                    <input type="hidden" name="sd" value="0">
                    <input
                        type="checkbox"
                        class="form__checkbox"
                        id="sd"
                        name="sd"
                        x-bind:value="(cats[cat].type === 'movie' || cats[cat].type === 'cartoon' || cats[cat].type === 'tv' || cats[cat].type === 'cartoontv') ? '1' : '0'""
                        @checked(old('stream') ?? $torrent->sd)
                    >
                    <label class="form__label" for="sd">{{ __('torrent.sd-content') }}?</label>
                </p>-->
                <input type="hidden" name="sd" value="0">
                @if (auth()->user()->group->is_modo || auth()->user()->group->is_internal)
                    <p class="form__group">
                        <input type="hidden" name="internal" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="internal"
                            name="internal"
                            value="1"
                            @checked(old('internal') ?? $torrent->internal)
                        >
                        <label class="form__label" for="internal">{{ __('torrent.internal') }}?</label>
                    </p>
                @else
                    <input type="hidden" name="internal" value="{{ $torrent->internal }}">
                @endif
                <!--@if (auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                    <p class="form__group">
                        <input type="hidden" name="personal_release" value="0">
                        <input
                            type="checkbox"
                            class="form__checkbox"
                            id="personal_release"
                            name="personal_release"
                            value="1"
                            @checked(old('personal_release') ?? $torrent->personal_release)
                        >
                        <label class="form__label" for="personal_release">Personal Release?</label>
                    </p>
                @else
                    <input type="hidden" name="personal_release" value="{{ $torrent->personal_release }}">
                @endif-->
                    <input type="hidden" name="personal_release" value="0">
                    @if (auth()->user()->group->is_modo || auth()->user()->group->is_internal || auth()->user()->group->can_upload)
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
                    <button class="form__button form__button--filled">
                        {{ __('common.submit') }}
                    </button>
                </p>
            </form>
        </div>
    </section>
@endsection

@if ($user->can_upload == 1 && $user->group->can_upload == 1)
    @section('sidebar')
        <section class="panelV2">
            <h2 class="panel__heading">
                <i class="{{ config('other.font-awesome') }} fa-info"></i>
                {{ __('common.info') }}
            </h2>
            <div class="panel__body">
                <p class="text-success">{!! __('torrent.announce-url-desc-url', ['url' => route('instructions')]) !!}</p>
                <br>
                <p>{{ __('torrent.tmdb') }} <a href="https://www.themoviedb.org/" target="_blank">https://www.themoviedb.org/</a></p>
                <p>{{ __('torrent.imdb') }} <a href="https://www.imdb.com/" target="_blank">https://www.imdb.com/</a></p>
                <p>{{ __('torrent.tvdb') }} <a href="https://www.thetvdb.com/" target="_blank">https://www.thetvdb.com/</a></p>
                <p>{{ __('torrent.mal') }} <a href="https://myanimelist.net/" target="_blank">https://myanimelist.net/</a></p>
                <p>{{ __('torrent.igdb') }} <a href="https://www.igdb.com/discover" target="_blank">https://www.igdb.com/discover</a></p>
            </div>
        </section>
    @endsection
@endif