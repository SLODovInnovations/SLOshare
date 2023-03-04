<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class PeerController extends Controller
{
    /**
     * Display All Pages.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('Staff.peer.index');
    }
}
