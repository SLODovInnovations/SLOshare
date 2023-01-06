<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Routing\Controller;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\BackupControllerTest
 */
class BackupController extends Controller
{
    /**
     * Display All Backups.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return \view('Staff.backup.index');
    }
}
