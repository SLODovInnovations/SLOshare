<div>
    <div class="container-fluid">
        <style>
            .form-group {
                margin-bottom: 5px !important;
            }

            .badge-extra {
                margin-bottom: 0;
            }
        </style>
        <div x-data="{ open: false }" class="container" id="torrent-list-search"
             style="margin-bottom: 0; padding: 10px 250px; border-radius: 5px;">
                <div class="search-article">
                    <div class="search-center">
                        <input wire:model.debounce.500ms="name" type="search" class="form-control" placeholder="Ime"/>
                    </div>
                </div>
                <div class="search-cat">
                    <button class="button-search-cast-tab" @click="open = ! open"
                            x-text="open ? '{{ __('common.search-hide') }}' : '{{ __('common.search-advanced') }}'"></button>
                </div>

                <!-- PODROBNO ISKANJE -->

                <div class="search-cast-tab">
                <select wire:model="perPage" class="form-control page-search">
			        <option value="25">25</option>
				    <option value="50">50</option>
				    <option value="100">100</option>
			    </select>


                <!-- faza 1 -->
                    <div x-show="open" class="category" id="torrent-advanced-search">
                        <table>
                            <tbody>
                                <tr>
                                <!-- Category -->
                                    <td valign="top" class="category-td">
                                        <fieldset style="border-right:0px;border-left:0px;border-bottom:0px;margin-right:5px;padding-top:10px;width:183px;">
                                            <legend>
                                                <label for="categories">{{ __('common.category') }}</label>
                                            </legend>
                                            <div class="margin-left:2px;">
                                                @php $categories = cache()->remember('categories', 3_600, fn () => App\Models\Category::all()->whereBetween('id', [1, 12])->sortBy('position')) @endphp
                                                @foreach ($categories as $category)
                                                <div class="kategorija">
                                                    <input type="checkbox" wire:model.prefetch="categories" value="{{ $category->id }}"> {{ $category->name }}
								                </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </td>
                                    <!-- Category -->

                                    <!-- Type -->
                                    <td valign="top" class="category-td">
                                        <fieldset style="border-right:0px;border-left:0px;border-bottom:0px;margin-right:5px;padding-top:10px;width:183px;">
                                            <legend style>
                                                <label for="types">{{ __('common.type') }}</label>
                                            </legend>
                                            <div class="margin-left:2px;">
                                                @php $types = cache()->remember('types', 3_600, fn () => App\Models\Type::all()->sortBy('position')) @endphp
                                                @foreach ($types as $type)
                                                <div class="kategorija">
                                                    <input type="checkbox" wire:model.prefetch="types" value="{{ $type->id }}"> {{ $type->name }}
								                </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </td>
                                    <!-- Type -->

                                    <!-- Resolution -->
                                    <td valign="top" class="category-td">
                                        <fieldset style="border-right:0px;border-left:0px;border-bottom:0px;margin-right:5px;padding-top:10px;width:183px;">
                                            <legend style>
                                                <label for="resolutions">{{ __('common.resolution') }}</label>
                                            </legend>
                                            <div class="margin-left:2px;">
                                                @php $resolutions = cache()->remember('resolutions', 3_600, fn () => App\Models\Resolution::all()->sortBy('position')) @endphp
                                                @foreach ($resolutions as $resolution)
                                                <div class="kategorija">
                                                    <input type="checkbox" wire:model.prefetch="resolutions" value="{{ $resolution->id }}"> {{ $resolution->name }}
								                </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </td>
                                    <!-- Resolution -->

                                    <!-- Genre -->
                                    <td valign="top" class="category-td">
                                        <fieldset style="border-right:0px;border-left:0px;border-bottom:0px;margin-right:5px;padding-top:10px;width:183px;">
                                            <legend style>
                                                <label for="genres">{{ __('common.genre') }}</label>
                                            </legend>
                                            <div class="margin-left:2px;">
                                                @foreach (App\Models\Genre::all()->sortBy('name') as $genre)
                                                <div class="kategorija">
                                                    <input type="checkbox" wire:model.prefetch="genres" value="{{ $genre->id }}"> {{ $genre->name }}
								                </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </td>
                                    <!-- Genre -->

                                </tr>
                            </tbody>
                        </table>
                    </div>
                <!-- faza 1 -->
                </div>
                <!-- PODROBNO ISKANJE -->
        </div>
        <!-- x-data -->
    </div>
    <!-- container-fluid -->
    <br>
    <div class="text-center">
        {{ $torrents->links() }}
    </div>
    <br>
    <div class="table-responsive block">
			<span class="torrent-listings-stats" style="float: right; color:#ffffff;">
				<strong>Št.:</strong> {{ number_format($torrentsStat->total) }} |
				<strong>Živi:</strong> {{ number_format($torrentsStat->alive) }} |
				<strong>Mrtvi:</strong> {{ number_format($torrentsStat->dead) }}
			</span>
        <div class="dropdown torrent-listings-action-bar">
@if (auth()->user()->group->can_upload)
            <a class="dropdown btn btn-success" data-toggle="dropdown" href="#" aria-expanded="true">
                {{ __('common.publish') }} {{ __('torrent.torrent') }}
                <i class="fas fa-caret-circle-right"></i>
            </a>
            <ul class="dropdown-menu">
                @foreach($categories as $category)
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" target="_blank"
                           href="{{ route('upload_form', ['category_id' => $category->id]) }}">
                            <span class="menu-text">{{ $category->name }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endforeach
            </ul>
@endif
			<a href="{{ route('categories.index') }}" class="btn btn-primary">
			    <i class="{{ config('other.font-awesome') }} fa-file"></i> {{ __('torrent.categories') }}
		    </a>
            <a href="{{ route('torrents') }}" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-list"></i> {{ __('torrent.list') }}
            </a>
            <a href="{{ route('cards') }}" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-image"></i> {{ __('torrent.cards') }}
            </a>
@if (auth()->user()->group->is_admin)
            <a href="#" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-clone"></i> {{ __('torrent.groupings') }}
            </a>
@endif
@if (auth()->user()->group->is_admin)
            <a href="{{ route('rss.index') }}" class="btn btn-warning">
                <i class="{{ config('other.font-awesome') }} fa-rss"></i> {{ __('rss.rss') }} {{ __('rss.feeds') }}
            </a>
@endif
        </div>
        <table class="table table-condensed table-striped table-bordered" id="torrent-list-table">
            <thead>
            <tr>
                <th class="torrent-listings-poster"></th>
                <th class="torrent-listings-format"></th>
                <th class="torrents-filename torrent-listings-overview">
                    <div sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null"
                         role="button">
                        {{ __('common.name') }}
                        @include('livewire.includes._sort-icon', ['field' => 'name'])
                    </div>
                </th>
                <th class="torrent-listings-download">
                    <div>
                        <i class="{{ config('other.font-awesome') }} fa-download"></i>
                    </div>
                </th>
                <th class="torrent-listings-tmdb">
                    <div>
                        <i class="{{ config('other.font-awesome') }} fa-id-badge"></i>
                    </div>
                </th>
                <th class="torrent-listings-size">
                    <div sortable wire:click="sortBy('size')" :direction="$sortField === 'size' ? $sortDirection : null"
                         role="button">
                        <i class="{{ config('other.font-awesome') }} fa-database"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'size'])
                    </div>
                </th>
                <th class="torrent-listings-seeders">
                    <div sortable wire:click="sortBy('seeders')"
                         :direction="$sortField === 'seeders' ? $sortDirection : null" role="button">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-alt-circle-up"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'seeders'])
                    </div>
                </th>
                <th class="torrent-listings-leechers">
                    <div sortable wire:click="sortBy('leechers')"
                         :direction="$sortField === 'leechers' ? $sortDirection : null" role="button">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-alt-circle-down"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'leechers'])
                    </div>
                </th>
                <th class="torrent-listings-completed">
                    <div sortable wire:click="sortBy('times_completed')"
                         :direction="$sortField === 'times_completed' ? $sortDirection : null" role="button">
                        <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'times_completed'])
                    </div>
                </th>
                <th class="torrent-listings-age">
                    <div sortable wire:click="sortBy('created_at')"
                         :direction="$sortField === 'created_at' ? $sortDirection : null" role="button">
                        {{ __('common.created_at') }}
                        @include('livewire.includes._sort-icon', ['field' => 'created_at'])
                    </div>
                </th>
            </tr>
            </thead>
        </table>
        @foreach($torrents as $torrent)
            @php $meta = null @endphp
            @if ($torrent->category->tv_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php
                        $meta = cache()->remember('tv.'.$torrent->tmdb, 3_600, function() use ($torrent) {
                            return App\Models\Tv::where('id', '=', $torrent->tmdb)->first();
                        })
                    @endphp
                @endif
            @endif
            @if ($torrent->category->movie_meta)
                @if ($torrent->tmdb || $torrent->tmdb != 0)
                    @php
                        $meta = cache()->remember('movie.'.$torrent->tmdb, 3_600, function() use ($torrent) {
                            return App\Models\Movie::where('id', '=', $torrent->tmdb)->first();
                        })
                    @endphp
                @endif
            @endif
            @if ($torrent->category->game_meta)
                @if ($torrent->igdb || $torrent->igdb != 0)
                    @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($torrent->igdb) @endphp
                @endif
            @endif

            <div class="col-md-4">
                <div class="card is-torrent">
                    <div class="card_head">
							<span class="badge-user text-bold" style="float:right;">
								<i class="{{ config('other.font-awesome') }} fa-fw fa-arrow-up text-green"></i>
								{{ $torrent->seeders }} /
								<i class="{{ config('other.font-awesome') }} fa-fw fa-arrow-down text-red"></i>
								{{ $torrent->leechers }} /
								<i class="{{ config('other.font-awesome') }} fa-fw fa-check text-orange"></i>
								{{ $torrent->times_completed }}
							</span>&nbsp;
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->getSize() }}
							</span>&nbsp;
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->resolution->name ?? 'No Res' }}
							</span>
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->type->name }}
							</span>&nbsp;
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->category->name }}
							</span>&nbsp;
                    </div>
                    <div class="card_body">
                        <div class="body_poster">
                            @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                                <img src="{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : 'https://via.placeholder.com/200x300' }}"
                                     class="show-poster" alt="{{ __('torrent.poster') }}">
                            @endif

                            @if ($torrent->category->game_meta && isset($meta) && $meta->cover['image_id'] && $meta->name)
                                <img src="https://images.igdb.com/igdb/image/upload/t_cover_big/{{ $meta->cover['image_id'] }}.jpg"
                                     class="show-poster"
                                     data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                                     data-image='<img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover['image_id'] }}.jpg"
									     alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                                     class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                            @endif

                            @if ($torrent->category->music_meta)
                                <img src="https://via.placeholder.com/200x300" class="show-poster"
                                     data-name='<i style="color: #a5a5a5;">N/A</i>'
                                     data-image='<img src="https://via.placeholder.com/200x300"
									     alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                                     class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                            @endif

                            @if ($torrent->category->no_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                         class="show-poster" alt="{{ __('torrent.poster') }}">
                                @else
                                    <img src="https://via.placeholder.com/200x300" class="show-poster"
                                         data-name='<i style="color: #a5a5a5;">N/A</i>'
                                         data-image='<img src="https://via.placeholder.com/200x300" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                                         class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                                @endif
                            @endif
                        </div>
                        <div class="body_description">
                            <h3 class="description_title">
                                <a href="{{ route('torrent', ['id' => $torrent->id]) }}">
                                    {{ $torrent->name }}
                                </a>
                            </h3>
                            @if (isset($meta->genres) && ($torrent->category->movie_meta || $torrent->category->tv_meta))
                                @foreach ($meta->genres as $genre)
                                    <span class="genre-label">
                                        <a href="{{ route('mediahub.genres.show', ['id' => $genre->id]) }}">
                                            <i class="{{ config('other.font-awesome') }} fa-theater-masks"></i> {{ $genre->name }}
                                        </a>
                                    </span>
                                @endforeach
                            @endif
                            @if (isset($meta->genres) && $torrent->category->game_meta)
                                @foreach ($meta->genres as $genre)
                                    <span class="genre-label">
                                        <a href="{{ route('mediahub.genres.show', ['id' => $genre['id']]) }}">
                                            <i class="{{ config('other.font-awesome') }} fa-theater-masks"></i> {{ $genre['name'] }}
                                        </a>
                                    </span>
                                @endforeach
                            @endif
                            <p class="description_plot">
                                @if($torrent->category->movie_meta || $torrent->category->tv_meta)
                                    {{ $meta->overview ?? '' }}
                                @endif

                                @if($torrent->category->game_meta)
                                    {{ $meta->summary ?? '' }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="card_footer">
                        <div style="float: left;">
                            @if ($torrent->anon == 1)
                                <span class="badge-user text-orange text-bold">{{ strtoupper(__('common.anonymous')) }}
                                    @if ($user->id === $torrent->user->id || $user->group->is_modo)
                                        <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
												({{ $torrent->user->username }})
											</a>
                                    @endif
									</span>
                            @else
                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
										<span class="badge-user text-bold"
                                              style="color:{{ $torrent->user->group->color }}; background-image:{{ $torrent->user->group->effect }};">
											<i class="{{ $torrent->user->group->icon }}" data-toggle="tooltip"
                                               data-original-title="{{ $torrent->user->group->name }}"></i>
											{{ $torrent->user->username }}
										</span>
                                </a>
                            @endif
                        </div>
                        <span class="badge-user text-bold" style="float: right;">
								<i class="{{ config('other.font-awesome') }} fa-thumbs-up text-gold"></i>
								@if($torrent->category->movie_meta || $torrent->category->tv_meta)
                                {{ round($meta->vote_average ?? 0) }}/10
                                ({{ $meta->vote_count ?? 0 }} {{ __('torrent.votes') }})
                            @endif
                            @if($torrent->category->game_meta)
                                {{ round($meta->rating ?? 0) }}/100
                                ({{ $meta->rating_count ?? 0 }} {{ __('torrent.votes') }})
                            @endif
							</span>
                    </div>
                </div>
            </div>
        @endforeach
        @if (! $torrents->count())
            <div class="margin-10 torrent-listings-no-result">
                {{ __('common.no-result') }}
            </div>
        @endif
        <br>
        <div class="text-center torrent-listings-pagination">
            {{ $torrents->links() }}
        </div>
        <br>
        <div class="container-fluid well torrent-listings-legend">
            <div class="text-center">
                <strong>{{ __('common.legend') }}:</strong>
                <button class='btn btn-success btn-circle torrent-listings-seeding' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.currently-seeding') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-arrow-up'></i>
                </button>
                <button class='btn btn-warning btn-circle torrent-listings-leeching' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.currently-leeching') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-arrow-down'></i>
                </button>
                <button class='btn btn-info btn-circle torrent-listings-incomplete' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.not-completed') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-spinner'></i>
                </button>
                <button class='btn btn-danger btn-circle torrent-listings-complete' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.completed-not-seeding') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-thumbs-down'></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ SLOYakuza\SecureHeaders\SecureHeaders::nonce('script') }}">
  document.addEventListener('livewire:load', function () {
    let myOptions = [
            @foreach($regions as $region)
      {
        label: "{{ $region->name }}", value: "{{ $region->id }}"
      },
        @endforeach
    ]
    VirtualSelect.init({
      ele: '#regions',
      options: myOptions,
      multiple: true,
      search: true,
      placeholder: "{{__('Select Regions')}}",
      noOptionsText: "{{__('No results found')}}",
    })

    let regions = document.querySelector('#regions')
    regions.addEventListener('change', () => {
      let data = regions.value
    @this.set('regions', data)
    })

    let myOptions2 = [
            @foreach($distributors as $distributor)
      {
        label: "{{ $distributor->name }}", value: "{{ $distributor->id }}"
      },
        @endforeach
    ]
    VirtualSelect.init({
      ele: '#distributors',
      options: myOptions2,
      multiple: true,
      search: true,
      placeholder: "{{__('Select Distributor')}}",
      noOptionsText: "{{__('No results found')}}",
    })

    let distributors = document.querySelector('#distributors')
    distributors.addEventListener('change', () => {
      let data = distributors.value
    @this.set('distributors', data)
    })
  })
</script>

