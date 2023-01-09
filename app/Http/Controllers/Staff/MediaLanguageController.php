<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreMediaLanguageRequest;
use App\Http\Requests\Staff\UpdateMediaLanguageRequest;
use App\Models\MediaLanguage;

class MediaLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $mediaLanguages = MediaLanguage::all()->sortBy('name');

        return \view('Staff.media_language.index', ['media_languages' => $mediaLanguages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.media_language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaLanguageRequest $request): \Illuminate\Http\RedirectResponse
    {
        MediaLanguage::create($request->validated());

        return \to_route('staff.media_languages.index')
            ->withSuccess('Medijski jezik je bil uspešno dodan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $mediaLanguage = MediaLanguage::findOrFail($id);

        return \view('Staff.media_language.edit', ['media_language' => $mediaLanguage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaLanguageRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        MediaLanguage::where('id', '=', $id)->update($request->validated());

        return \to_route('staff.media_languages.index')
            ->withSuccess('Jezik medijev je bil uspešno posodobljen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $mediaLanguage = MediaLanguage::findOrFail($id);
        $mediaLanguage->delete();

        return \to_route('staff.media_languages.index')
            ->withSuccess('Jezik medijev je bil uspešno izbrisan');
    }
}
