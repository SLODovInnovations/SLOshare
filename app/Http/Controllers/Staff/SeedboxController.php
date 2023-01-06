<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Seedbox;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\SeedboxControllerTest
 */
class SeedboxController extends Controller
{
    /**
     * Display All Registered Seedboxes.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $seedboxes = Seedbox::with('user')->latest()->paginate(50);

        return \view('Staff.seedbox.index', ['seedboxes' => $seedboxes]);
    }

    /**
     * Delete A Registered Seedbox.
     *
     * @throws \Exception
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        Seedbox::findOrFail($id)->delete();

        return \to_route('staff.seedboxes.index')
            ->withSuccess('Seedbox zapis je bil uspešno izbrisan');
    }
}
