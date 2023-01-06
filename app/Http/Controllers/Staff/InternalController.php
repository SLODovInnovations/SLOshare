<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Internal;
use Illuminate\Http\Request;

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
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $internal = Internal::findOrFail($id);

        $internal->name = $request->input('name');
        $internal->icon = $request->input('icon');
        $internal->effect = $request->input('effect');

        $v = \validator($internal->toArray(), [
            'name'      => 'required',
            'icon'      => 'required',
            'effect'    => 'required',
        ]);

        if ($v->fails()) {
            return \to_route('staff.internals.index')
                ->withErrors($v->errors());
        }

        $internal->save();

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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $internal = new Internal();
        $internal->name = $request->input('name');
        $internal->icon = $request->input('icon');
        $internal->effect = $request->input('effect');

        $v = \validator($internal->toArray(), [
            'name'     => 'required|unique:internals',
            'icon',
            'effect',
        ]);

        if ($v->fails()) {
            return \to_route('staff.internals.index')
                ->withErrors($v->errors());
        }

        $internal->save();

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
