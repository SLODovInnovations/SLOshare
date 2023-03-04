<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display All Companies.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('mediahub.company.index');
    }
}
