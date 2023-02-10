<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreHomeVideoRequest;
use App\Http\Requests\Staff\UpdateHomeVideoRequest;
use App\Models\HomeVideo;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\GroupControllerTest
 */
class HomeVideoController extends Controller
{
    /**
     * Display All Blacklisted Clients.
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {

        $clients = HomeVideo::latest()->get();

        return view('Staff.home.videos.index', ['clients' => $clients]);
    }

    /**
     * Home Video Edit Form.
     */
    public function edit(Request $request, int $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {

        $client = HomeVideo::findOrFail($id);

        return view('Staff.home.videos.edit', ['client' => $client]);
    }

    /**
     * Edit A Home Video.
     */
    public function update(UpdateHomeVideoRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        HomeVideo::where('id', '=', $id)->update($request->validated());

        cache()->forget('home_video');

        return \to_route('staff.homes.videos.index')
            ->withSuccess('Odjemalec na črnem seznamu je bil uspešno posodobljen!');
    }

    /**
     * Home Video Add Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.home.videos.create');
    }

    /**
     * Store A New Home Video.
     */
    public function store(StoreHomeVideoRequest $request): \Illuminate\Http\RedirectResponse
    {
        HomeVideo::create($request->validated());

        cache()->forget('home_video');

        return to_route('staff.homes.videos.index')
            ->withSuccess('Video na domači strani je bil uspešno shranjen!');
    }

    /**
     * Delete A Home Video.
     */
     public function destroy(int $id): \Illuminate\Http\RedirectResponse
     {
         HomeVideo::findOrFail($id)->delete();

         cache()->forget('home_video');

        return to_route('staff.homes.videos.index')
            ->withSuccess('Video na domači strani je bil uspešno odstranjen!');
    }
}
