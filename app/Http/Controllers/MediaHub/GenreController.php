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
        $genres = Genre::withCount(['tv', 'cartoontv', 'movie', 'cartoon'])->orderBy('name')->get();

        return view('mediahub.genre.index', ['genres' => $genres]);
    }
}
