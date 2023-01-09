<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreInternalRequest;
use App\Http\Requests\Staff\UpdateInternalRequest;
use App\Models\Internal;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\GroupControllerTest
 */
class InternalController extends Controller
{
    /**
     * Display All Internal Groups.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $internals = Internal::all()->sortBy('name');

        return \view('Staff.internals.index', ['internals' => $internals]);
    }

    /**
     * Edit A group.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $internal = Internal::findOrFail($id);

        return \view('Staff.internals.edit', ['internal' => $internal]);
    }

    /**
     * Save a group change.
     */
    public function update(UpdateInternalRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        Internal::where('id', '=', $id)->update($request->validated());

        return \to_route('staff.internals.index')
            ->withSuccess('Notranja skupina je bila uspešno posodobljena!');
    }

    /**
     * Internal Add Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.internals.create');
    }

    /**
     * Store A New Internal Group.
     */
    public function store(StoreInternalRequest $request): \Illuminate\Http\RedirectResponse
    {
        Internal::create($request->validated());

        return \to_route('staff.internals.index')
            ->withSuccess('Dodana je nova notranja skupina!');
    }

    /**
     * Delete A Internal Group.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $internal = Internal::findOrFail($id);
        $internal->delete();

        return \to_route('staff.internals.index')
            ->withSuccess('Skupina je bila odstranjena.');
    }
}
