<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    private $categories;

    public function __construct()
    {
        $this->categories = $this->getCategories();
    }

    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::updateOrCreate($category);
        }
    }

    private function getCategories(): array
    {
        return [
            [
                'id'             => 1,
                'name'           => 'Video',
                'position'       => 0,
                'icon'           => config('other.font-awesome').' fa-film',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 1,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 0,
            ],
            [
                'id'             => 2,
                'name'           => 'TV Serije',
                'position'       => 1,
                'icon'           => config('other.font-awesome').' fa-tv-retro',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 1,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 0,
            ],
            [
                'id'             => 3,
                'name'           => 'Risanke',
                'position'       => 2,
                'icon'           => config('other.font-awesome').' fa-baby-carriage',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 1,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 0,
            ],
            [
                'id'             => 4,
                'name'           => 'Risanke TV',
                'position'       => 3,
                'icon'           => config('other.font-awesome').' fa-baby',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 1,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 0,
            ],
            [
                'id'             => 5,
                'name'           => 'Dokumentarci',
                'position'       => 4,
                'icon'           => config('other.font-awesome').' fa-video',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 6,
                'name'           => 'Šport',
                'position'       => 5,
                'icon'           => config('other.font-awesome').' fa-futbol',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 7,
                'name'           => 'Anime',
                'position'       => 6,
                'icon'           => config('other.font-awesome').' fa-baby',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 8,
                'name'           => 'Glasba',
                'position'       => 7,
                'icon'           => config('other.font-awesome').' fa-music',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 1,
                'no_meta'        => 0,
            ],
            [
                'id'             => 9,
                'name'           => 'Igre',
                'position'       => 8,
                'icon'           => config('other.font-awesome').' fa-gamepad',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 1,
                'music_meta'     => 0,
                'no_meta'        => 0,
            ],
            [
                'id'             => 10,
                'name'           => 'Programi',
                'position'       => 9,
                'icon'           => config('other.font-awesome').' fa-compact-disc',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 11,
                'name'           => 'AvdioBook',
                'position'       => 10,
                'icon'           => config('other.font-awesome').' fa-file-audio',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 12,
                'name'           => 'Slike',
                'position'       => 11,
                'icon'           => config('other.font-awesome').' fa-image',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 13,
                'name'           => 'eKnjige',
                'position'       => 12,
                'icon'           => config('other.font-awesome').' fa-atlas',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
            [
                'id'             => 14,
                'name'           => 'XXX (Nad 18 let)',
                'position'       => 13,
                'icon'           => config('other.font-awesome').' fa-heart',
                'num_torrent'    => 0,
                'image'          => null,
                'movie_meta'     => 0,
                'tv_meta'        => 0,
                'cartoon_meta'   => 0,
                'cartoontv_meta' => 0,
                'game_meta'      => 0,
                'music_meta'     => 0,
                'no_meta'        => 1,
            ],
        ];
    }
}
