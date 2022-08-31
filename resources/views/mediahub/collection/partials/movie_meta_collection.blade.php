        <div class="panel panel-chat shoutbox">
            <div class="panel-heading">
                <h4><i class="{{ config("other.font-awesome") }} fa-film"></i> Filmi</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td>
                            <section class="recommendations">
                                @foreach($collection->movie->sortBy('release_date') as $movie)
                                    <div class="item mini backdrop mini_card col-md-3">
                                        <div class="image_content">
                                            @php
                                                $torrent_temp = App\Models\Torrent::where('tmdb', '=', $movie->id)
                                                ->whereIn('category_id', function ($query) {
                                                $query->select('id')->from('categories')->where('movie_meta', '=', true);
                                                })->first()
                                            @endphp
                                            <a href="{{ route('torrents.similar', ['category_id' => $torrent_temp->category_id, 'tmdb' => $movie->id]) }}">
                                                <div>
                                                    <img class="backdrop"
                                                         src="{{ tmdb_image('poster_mid', $movie->poster) }}">
                                                </div>
                                                <div style=" margin-top: 8px;">
                                                    <span class="badge-extra"><i
                                                                class="fas fa-calendar text-purple"></i> {{ __('common.year') }}: {{ substr($movie->release_date, 0, 4) }}</span>
                                                    <span class="badge-extra"><i class="fas fa-star text-gold"></i> {{ __('torrent.rating') }}: {{ $movie->vote_average }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </section>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>