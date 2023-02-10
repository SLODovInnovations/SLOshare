<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display All Genres.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $genres = Genre::paginate(25);

        return view('mediahub.genre.index', ['genres' => $genres]);
    }

    /**
     * Show A Genre.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $genre = Genre::withCount(['tv', 'movie'])->findOrFail($id);
        $shows = $genre->tv()->has('torrents')->oldest('name')->paginate(25, ['*'], 'showsPage');
        $cartoontvs = $genre->cartoontv()->has('torrents')->oldest('name')->paginate(25, ['*'], 'cartoontvsPage');
        $movies = $genre->movie()->has('torrents')->oldest('title')->paginate(25, ['*'], 'moviesPage');
        $cartoons = $genre->cartoon()->has('torrents')->oldest('title')->paginate(25, ['*'], 'cartoonsPage');

        return view('mediahub.genre.show', [
            'genre'      => $genre,
            'shows'      => $shows,
            'cartoontvs' => $cartoontvs,
            'movies'     => $movies,
            'cartoons'   => $cartoons,
        ]);
    }
}
