<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display All Companies.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('mediahub.company.index');
    }

    /**
     * Show A Company.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $company = Company::withCount('tv', 'cartoontv', 'movie', 'cartoon')->findOrFail($id);
        $shows = $company->tv()->has('torrents')->oldest('name')->paginate(25, ['*'], 'showsPage');
        $cartoontvs = $company->cartoontv()->has('torrents')->oldest('name')->paginate(25, ['*'], 'cartoontvsPage');
        $movies = $company->movie()->has('torrents')->oldest('title')->paginate(25, ['*'], 'moviesPage');
        $cartoons = $company->cartoon()->has('torrents')->oldest('title')->paginate(25, ['*'], 'cartoonsPage');

        return view('mediahub.company.show', [
            'company' => $company,
            'shows'   => $shows,
            'cartoontvs'   => $cartoontv,
            'movies'  => $movies,
            'cartoons'  => $cartoon,
        ]);
    }
}
