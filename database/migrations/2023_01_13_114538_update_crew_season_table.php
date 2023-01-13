<?php

use App\Models\Season;
use App\Models\CartoonTv;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (CartoonTv::all() as $tv) {
            $data = (new \App\Services\Tmdb\Client\CartoonTv($tv->id))->getData();

            foreach ($data['seasons'] as $season) {
                $season = (new \App\Services\Tmdb\Client\Season($cartoontv->id, \sprintf('%02d', $season['season_number'])))->getData();
                $seasonModel = Season::find($season['id']);

                if (isset($season['credits']['crew'])) {
                    foreach ($season['credits']['crew'] as $crewMember) {
                        $seasonModel->crew()->updateExistingPivot($crewMember['id'], [
                            'department' => $crewMember['department'],
                            'job'        => $crewMember['job'],
                        ]);
                    }
                }
            }
        }
    }
};
