@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('edit_form', ['id' => $torrent->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ __('torrent.torrent') }} {{ __('common.edit') }}</span>
        </a>
    </li>
@endsection

@section('content')
        <div class="container">
            <h2>{{ __('common.edit') }}: {{ $torrent->name }}</h2>
            <div class="block">
                <form role="form" method="POST" action="{{ route('edit', ['id' => $torrent->id]) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">{{ __('torrent.title') }}</label>
                        <label>
                            <input type="text" class="form-control" name="name" value="{{ $torrent->name }}" required>
                        </label>
                    </div>

                        <div class="form-group">
                            <label for="torrent-banner">{{ __('torrent.banner') }}</label>
                            <input class="upload-form-file" type="file" accept=".jpg, .jpeg, .png"
                                   name="torrent-banner">
                        </div>

                    <div class="form-group">
                        <label for="category_id">{{ __('torrent.category') }}</label>
                        <label>
                            <select name="category_id" id="autocat" class="form-control">
                                <option value="{{ $torrent->category->id }}" selected>{{ $torrent->category->name }}
                                    ({{ __('torrent.current') }})
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="type">{{ __('torrent.type') }}</label>
                        <label>
                            <select name="type_id" id="autotype" class="form-control">
                                <option value="{{ $torrent->type->id }}" selected>{{ $torrent->type->name }}
                                    ({{ __('torrent.current') }})
                                </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    @php $data = App\Models\Category::where('id', '=', !empty($category_id) ? $category_id : old('category_id'))->first();@endphp
                        <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
                            <label for="resolution_ids">{{ __('torrent.resolution') }}</label>
                            <label>
                                <select name="resolution_id" id="autores" class="form-control">
                                    @if (! $torrent->resolution)
                                        <option hidden="" disabled="disabled" selected="selected" value="">{{ __('torrent.select-resolution') }}
                                        </option>)
                                    @else
                                        <option value="{{ $torrent->resolution->id }}"
                                                selected>{{ $torrent->resolution->name }}
                                            ({{ __('torrent.current') }})
                                        </option>
                                    @endif
                                    @foreach ($resolutions as $resolution)
                                        <option value="{{ $resolution->id }}">{{ $resolution->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    @endif

                        <div class="form-group"  x-show="meta == 'movie' || meta == 'tv'">
                            <label for="name">TMDB ID <b>({{ __('request.required') }})</b></label>
                            <br>
                            <label for="name">URL za TMDB ID: <a href="https://www.themoviedb.org/" target="_blank"><b>https://www.themoviedb.org/</b></a></label>
                            <label>
                                <input type="number" name="tmdb" id="autotmdb" class="form-control"
                                       value="{{ $torrent->tmdb }}" required>
                            </label>
                        </div>

                        <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
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
                                       value="{{ $torrent->imdb }}">
                            </label>
                        </div>

                        <div class="form-group" x-show="meta == 'tv'">
                            <label for="name">TVDB ID ({{ __('torrent.optional') }})</label>
                            <br>
                            <label for="name">URL za TVDB ID: <a href="https://www.thetvdb.com/" target="_blank"><b>https://www.thetvdb.com/</b></a></label>
                            <label>
                                <input type="number" name="tvdb" id="autotvdb"
                                       value="{{ $torrent->tvdb }}"
                                       class="form-control" required>
                            </label>
                        </div>

                        <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
                            <label for="name">MAL ID ({{ __('torrent.required-anime') }})</label>
                            <br>
                            <label for="name">URL za MAL ID: <a href="https://myanimelist.net/" target="_blank"><b>https://myanimelist.net/</b></a></label>
                            <label>
                                <input type="number" name="mal" value="{{ $torrent->mal }}" class="form-control"
                                       required>
                            </label>
                        </div>

                        <div class="form-group" x-show="meta == 'game'">
                            <label for="name">IGDB ID <b>({{ __('torrent.required-games') }})</b></label>
                            <br>
                            <label for="name">URL za IGDB ID: <a href="https://www.igdb.com/discover" target="_blank"><b>https://www.igdb.com/discover</b></a></label>
                            <label>
                                <input type="number" name="igdb" value="{{ $torrent->igdb }}" class="form-control"
                                       required>
                            </label>
                        </div>

                    @if ($torrent->category->tv_meta)
                        <div class="form-group">
                            <label for="season_number">{{ __('torrent.season-number') }} <b>({{ __('request.required') }} za
                                    TV)</b></label>
                            <input type="number" name="season_number" id="season_number" class="form-control"
                                   value="{{ $torrent->season_number }}" required>
                        </div>
                    @endif

                    @if ($torrent->category->tv_meta)
                        <div class="form-group">
                            <label for="episode_number">{{ __('torrent.episode-number') }} <b>({{ __('request.required') }}za
                                    TV. Uporabite "0" za sezonske pakete.)</b></label>
                            <input type="number" name="episode_number" id="episode_number" class="form-control"
                                   value="{{ $torrent->episode_number }}" required>
                        </div>
                    @endif

                        <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
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

                        <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
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

                    <div class="form-group">
                        <label for="description">{{ __('common.description') }}</label>
                        <label for="upload-form-description"></label>
                        <textarea id="editor" name="description" cols="30" rows="10"
                                  class="form-control">{{ $torrent->description }}</textarea>
                    </div>

                    <!--    <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
                            <label for="mediainfo">{{ __('torrent.media-info-parser') }}</label>
                            <label for="upload-form-description"></label>
                            <textarea id="upload-form-description" name="mediainfo" cols="30" rows="10"
                                      class="form-control"
                                      placeholder="{{ __('torrent.media-info-paste') }}">{{ old('mediainfo') }}</textarea>
                        </div>-->

                    <!--    <div class="form-group" x-show="meta == 'movie' || meta == 'tv'">
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
                        <br x-show="meta == 'movie' || meta == 'tv'">

                        <label for="stream" class="control-label" x-show="meta == 'movie' || meta == 'tv'">{{ __('torrent.stream-optimized') }}?</label>
                        <div class="radio-inline" x-show="meta == 'movie' || meta == 'tv'">
                            <label><input type="radio" name="stream" id="stream"
                                          value="(meta == 'movie' || meta == 'tv') ? '1' : '0'"{{ old('stream') ? ' checked' : '' }}>{{ __('common.yes') }}</label>
                        </div>
                        <div class="radio-inline" x-show="meta == 'movie' || meta == 'tv'">
                            <label><input type="radio" name="stream" id="stream"
                                          value="0"{{ !old('stream') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                        </div>

                        <br x-show="meta == 'movie' || meta == 'tv'">

                        <label for="sd" class="control-label" x-show="meta == 'movie' || meta == 'tv'">{{ __('torrent.sd-content') }}?</label>
                        <div class="radio-inline" x-show="meta == 'movie' || meta == 'tv'">
                            <label><input type="radio" name="sd"
                                          x-bind:value="(meta == 'movie' || meta == 'tv') ? '1' : '0'"{{ old('sd') ? ' checked' : '' }}>{{ __('common.yes') }}</label>
                        </div>
                        <div class="radio-inline" x-show="meta == 'movie' || meta == 'tv'">
                            <label><input type="radio" name="sd"
                                          value="0"{{ !old('sd') ? ' checked' : '' }}>{{ __('common.no') }}</label>
                        </div>

                        <br>
@endif

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
                        <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
@endsection
