<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;
use App\Models\Person;

class PersonController extends Controller
{
    /**
     * Display All Persons.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('mediahub.person.index');
    }

    /**
     * Show A Person.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $person = Person::with([
            'tv' => fn ($query) => $query->has('torrents'),
            'tv.genres',
            'cartoontv' => fn ($query) => $query->has('torrents'),
            'cartoontv.genres',
            'movie' => fn ($query) => $query->has('torrents'),
            'movie.genres',
            'cartoon' => fn ($query) => $query->has('torrents'),
            'cartoon.genres'
        ])->findOrFail($id);

        return view('mediahub.person.show', ['person' => $person]);
    }
}
