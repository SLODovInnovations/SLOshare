<div>
    <div class="mb-10">
        <input type="text" wire:model="search" class="form-control" placeholder="{{ __('torrent.search-by-name') }}"/>
    </div>

    @foreach($cartoontvs as $cartoontv)
        <div class="col-md-12">
            <div class="card is-torrent" style=" height: 265px;">
                <div class="card_head">
					<span class="badge-user text-bold" style="float:right;">
						{{ $cartoontv->seasons_count }} Seasons
					</span>
                    @if ($cartoontv->networks)
                        @foreach ($cartoontv->networks as $network)
                            <span class="badge-user text-bold" style="float:right;">
								{{ $network->name }}
							</span>
                        @endforeach
                    @endif
                </div>
                <div class="card_body">
                    <div class="body_poster">
                        <img src="{{ isset($cartoontv->poster) ? tmdb_image('poster_mid', $cartoontv->poster) : '/img/SLOshare/movie_no_image_search.jpg' }}"
                             class="show-poster">
                    </div>
                    <div class="body_description">
                        <h3 class="description_title">
                            <a href="{{ route('mediahub.cartoontv.show', ['id' => $cartoontv->id]) }}">{{ $cartoontv->name }}
                                @if($cartoontv->first_aired)
                                    <span class="text-bold text-pink"> {{ $cartoontv->first_aired }}</span>
                                @endif
                            </a>
                        </h3>
                        @if ($cartoontv->genres)
                            @foreach ($cartoontv->genres as $genre)
                                <span class="genre-label">{{ $genre->name }}</span>
                            @endforeach
                        @endif
                        <p class="description_plot">
                            {{ $cartoontv->overview }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <br>
    <div class="text-center">
        {{ $cartoontvs->links() }}
    </div>
</div>
