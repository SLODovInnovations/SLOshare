<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Warning;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\WarningControllerTest
 */
class WarningController extends Controller
{
    /**
     * Warnings Log.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $warnings = Warning::with(['torrenttitle', 'warneduser'])->latest()->paginate(25);
        $warningcount = Warning::count();

        return view('Staff.warning.index', ['warnings' => $warnings, 'warningcount' => $warningcount]);
    }
}
