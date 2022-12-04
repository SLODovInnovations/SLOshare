<?php

namespace App\Http\Controllers\MediaHub;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\CartoonTv;

class CartoonTvSeasonController extends Controller
{
    /**
     * Show A Cartoon TV Season.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $season = Season::with(['episodes', 'torrents'])->findOrFail($id);
        $cartoontv = CartoonTv::where('id', '=', $season->cartoontv_id)->first();

        return \view('mediahub.cartoontv.season.show', [
            'season'      => $season,
            'cartoontv'   => $cartoontv,
        ]);
    }
}
