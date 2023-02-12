    <div class="torrent box container single">
        <div class="movie-wrapper">
            <div class="movie-overlay"></div>

            <div class="movie-poster">
                <img src="{{ $collection->poster ? tmdb_image('poster_big', $collection->poster) : '/img/SLOshare/movie_no_image_400x600.jpg' }}"
                     class="img-responsive" id="meta-poster">
            </div>

            <div class="meta-info">
                <div class="tags">
                    {{ __('mediahub.collections') }}
                </div>

                <div class="movie-backdrop"
                     style="background-image: url('{{ $collection->backdrop ? tmdb_image('back_big', $collection->backdrop) : '/img/SLOshare/movie_no_image_banner.jpg' }}');"></div>

                <div class="movie-top">
                    <h1 class="movie-heading">
                        <span class="text-bold">{{ $collection->name }}</span>
                    </h1>

                    <div class="movie-overview">
                        {{ $collection->overview }}
                    </div>
                </div>
                <div class="movie-bottom">
                    <a href="{{ route('torrents', ['collectionId' => $collection->id]) }}" role="button"
                       class="btn btn-sm btn-labeled btn-success">
                    <span class='btn-label'>
                        <i class='{{ config('other.font-awesome') }} fa-eye'></i> Seznam zbirke Torrentov
                    </span>
                    </a>
                </div>
            </div>
        </div>