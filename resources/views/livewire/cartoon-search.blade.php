<section class="panelV2">
    <header class="panel__header">
        <h2 class="panel__heading">{{ __('mediahub.cartoons') }}</h2>
        <div class="panel__actions">
            <div class="panel__action">
                <div class="form__group">
                    <input
                        class="form__text"
                        placeholder=""
                        type="text"
                        wire:model.debounce.250ms="search"
                    />
                    <label class="form__label form__label--floating">
                        {{ __('torrent.search-by-name') }}
                    </label>
                </div>
            </div>
        </div>
    </header>
    {{ $cartoons->links('partials.pagination') }}
    <div class="panel__body">
        @forelse($cartoons as $cartoon)
            <div class="col-md-12">
                <div class="card is-torrent" style=" height: 265px;">
                    <div class="card_head">
                        @if ($cartoon->companies)
                            @foreach ($cartoon->companies as $company)
                                <span class="badge-user text-bold" style="float:right;">
									{{ $company->name }}
								</span>
                            @endforeach
                        @endif
                    </div>
                    <div class="card_body">
                        <div class="body_poster">
                            <img src="{{ isset($cartoon->poster) ? tmdb_image('poster_mid', $cartoon->poster) : '/img/SLOshare/movie_no_image_search.jpg' }}"
                                 class="show-poster">
                        </div>
                        <div class="body_description">
                            <h3 class="description_title">
                                <a href="{{ route('mediahub.cartoons.show', ['id' => $cartoon->id]) }}">{{ $cartoon->title }}
                                    @if($cartoon->release_date)
                                        <span class="text-bold text-pink"> {{ $cartoon->release_date }}</span>
                                    @endif
                                </a>
                            </h3>
                            @if ($cartoon->genres)
                                @foreach ($cartoon->genres as $genre)
                                    <span class="genre-label">{{ $genre->name }}</span>
                                @endforeach
                            @endif
                            <p class="description_plot">
                                {{ $cartoon->overview }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            Ni Risank.
        @endforelse
    </div>
    {{ $cartoons->links('partials.pagination') }}
</section>
