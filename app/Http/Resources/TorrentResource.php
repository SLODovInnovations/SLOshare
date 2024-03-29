<?php

namespace App\Http\Resources;

use App\Models\Movie;
use App\Models\Cartoon;
use App\Models\Tv;
use App\Models\CartoonTv;
use Illuminate\Http\Resources\Json\JsonResource;

class TorrentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $meta = null;

        if ($this->category->tv_meta && ($this->tmdb !== 0)) {
            $meta = Tv::with(['genres:name'])->where('id', '=', $this->tmdb)->first();
        }

        if ($this->category->cartoontv_meta && ($this->tmdb !== 0)) {
            $meta = CartoonTv::with(['genres:name'])->where('id', '=', $this->tmdb)->first();
        }

        if ($this->category->movie_meta && ($this->tmdb !== 0)) {
            $meta = Movie::with(['genres:name'])->where('id', '=', $this->tmdb)->first();
        }

        if ($this->category->cartoon_meta && ($this->tmdb !== 0)) {
            $meta = Cartoon::with(['genres:name'])->where('id', '=', $this->tmdb)->first();
        }

        return [
            'type'       => 'torrent',
            'id'         => (string) $this->id,
            'attributes' => [
                'meta' => [
                    'poster' => isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : '/img/SLOshare/mediahub_no_image_90x135.jpg',
                    'genres' => isset($meta->genres) ? $meta->genres->pluck('name')->implode(', ') : 'Noben',
                ],
                'name'            => $this->name,
                'release_year'    => $this->release_year,
                'category'        => $this->category->name,
                'type'            => $this->type->name,
                'resolution'      => $this->when(isset($this->resolution_id), $this->resolution->name ?? ''),
                'distributor'     => $this->when(isset($this->distributor_id), $this->distributor->name ?? ''),
                'region'          => $this->when(isset($this->region_id), $this->region->name ?? ''),
                'media_info'      => $this->mediainfo,
                'bd_info'         => $this->bdinfo,
                'description'     => $this->description,
                'info_hash'       => $this->info_hash,
                'size'            => $this->size,
                'num_file'        => $this->num_file,
                'freeleech'       => $this->free.'%',
                'double_upload'   => $this->doubleup,
                'internal'        => $this->internal,
                'uploader'        => $this->anon ? 'Anonymous' : $this->user->username,
                'seeders'         => $this->seeders,
                'leechers'        => $this->leechers,
                'times_completed' => $this->times_completed,
                'tmdb_id'         => $this->tmdb,
                'imdb_id'         => $this->imdb,
                'tvdb_id'         => $this->tvdb,
                'mal_id'          => $this->mal,
                'igdb_id'         => $this->igdb,
                'category_id'     => $this->category_id,
                'type_id'         => $this->type_id,
                'resolution_id'   => $this->when($this->resolution_id !== null, $this->resolution_id),
                'distributor_id'  => $this->when($this->distributor_id !== null, $this->distributor_id),
                'region_id'       => $this->when($this->region_id !== null, $this->region_id),
                'created_at'      => $this->created_at,
                'download_link'   => route('torrent.download.rsskey', ['id' => $this->id, 'rsskey' => auth('api')->user()->rsskey]),
                'magnet_link'     => $this->when(config('torrent.magnet') === true, 'magnet:?dn='.$this->name.'&xt=urn:btih:'.$this->info_hash.'&as='.route('torrent.download.rsskey', ['id' => $this->id, 'rsskey' => auth('api')->user()->rsskey]).'&tr='.route('announce', ['passkey' => auth('api')->user()->passkey]).'&xl='.$this->size),
                'details_link'    => route('torrent', ['id' => $this->id]),
            ],
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     */
    public function withResponse($request, $response): void
    {
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
