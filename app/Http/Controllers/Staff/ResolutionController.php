<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreResolutionRequest;
use App\Http\Requests\Staff\UpdateResolutionRequest;
use App\Models\Resolution;
use Exception;

class ResolutionController extends Controller
{
    /**
     * Display All Resolutions.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $resolutions = Resolution::all()->sortBy('position');

        return view('Staff.resolution.index', ['resolutions' => $resolutions]);
    }

    /**
     * Show Resolution Create Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.resolution.create');
    }

    /**
     * Store A New Resolution.
     */
    public function store(StoreResolutionRequest $request): \Illuminate\Http\RedirectResponse
    {
        Resolution::create($request->validated());

        return to_route('staff.resolutions.index')
            ->withSuccess('Resolucija je bila uspešno dodana');
    }

    /**
     * Resolution Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $resolution = Resolution::findOrFail($id);

        return view('Staff.resolution.edit', ['resolution' => $resolution]);
    }

    /**
     * Edit A Resolution.
     */
    public function update(UpdateResolutionRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        Resolution::where('id', '=', $id)->update($request->validated());

        return to_route('staff.resolutions.index')
            ->withSuccess('Resolucija je bila uspešno spremenjena');
    }

    /**
     * Delete A Resolution.
     *
     * @throws Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $resolution = Resolution::findOrFail($id);
        $resolution->delete();

        return to_route('staff.resolutions.index')
            ->withSuccess('Resolucija je uspešno izbrisana');
    }
}
