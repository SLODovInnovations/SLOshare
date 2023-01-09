<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreTypeRequest;
use App\Http\Requests\Staff\UpdateTypeRequest;
use App\Models\Type;

/**
 * @see \Tests\Feature\Http\Controllers\Staff\TypeControllerTest
 */
class TypeController extends Controller
{
    /**
     * Display All Types.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $types = Type::all()->sortBy('position');

        return \view('Staff.type.index', ['types' => $types]);
    }

    /**
     * Show Type Create Form.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.type.create');
    }

    /**
     * Store A New Type.
     */
    public function store(StoreTypeRequest $request): \Illuminate\Http\RedirectResponse
    {
        Type::create($request->validated());

        return \to_route('staff.types.index')
            ->withSuccess('Vnesite uspešno dodano');
    }

    /**
     * Type Edit Form.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $type = Type::findOrFail($id);

        return \view('Staff.type.edit', ['type' => $type]);
    }

    /**
     * Edit A Type.
     */
    public function update(UpdateTypeRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        Type::where('id', '=', $id)->update($request->validated());

        return \to_route('staff.types.index')
            ->withSuccess('Vnesite uspešno spremenjeno');
    }

    /**
     * Delete A Type.
     *
     * @throws \Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return \to_route('staff.types.index')
            ->withSuccess('Vnesite uspešno izbrisano');
    }
}
