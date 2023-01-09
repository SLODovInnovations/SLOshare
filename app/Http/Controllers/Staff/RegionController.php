<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreRegionRequest;
use App\Http\Requests\Staff\UpdateRegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegionController extends Controller
{
    /**
     * Display All Regions.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $regions = Region::all()->sortBy('position');

        return \view('Staff.region.index', ['regions' => $regions]);
    }

    /**
     * Show Region Create Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.region.create');
    }

    /**
     * Store A New Region.
     */
    public function store(StoreRegionRequest $request): \Illuminate\Http\RedirectResponse
    {
        Region::create($request->validated());

        return \to_route('staff.regions.index')
                ->withSuccess('Regija je bila uspešno dodana');
    }

    /**
     * Region Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $region = Region::findOrFail($id);

        return \view('Staff.region.edit', ['region' => $region]);
    }

    /**
     * Edit A Region.
     */
    public function update(UpdateRegionRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        Region::where('id', '=', $id)->update($request->validated());

        return \to_route('staff.regions.index')
                ->withSuccess('Regija je bila uspešno spremenjena');
    }

    /**
     * Delete A Region.
     *
     * @throws \Exception
     */
    public function destroy(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $region = Region::findOrFail($id);

        $validated = $request->validate([
            'region_id' => [
                'required',
                'exists:regions,id',
                Rule::notIn([$region->id]),
            ],
        ]);
        $region->torrents()->update($validated);
        $region->delete();

        return \to_route('staff.regions.index')
            ->withSuccess('Regija je bila uspešno izbrisana');
    }
}
