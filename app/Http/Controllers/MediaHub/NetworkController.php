<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;

class NetworkController extends Controller
{
    /**
     * Display All Networks.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('mediahub.network.index');
    }
}
