<?php

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
        Schema::table('cartoon_tv_crew', function (Blueprint $table) {
            $table->string('department')->nullable();
            $table->string('job')->nullable();
        });

        foreach (CartoonTv::all() as $cartoontv) {
            $data = (new \App\Services\Tmdb\Client\CartoonTv($cartoontv->id))->getData();

            if (isset($data['credits']['crew'])) {
                foreach ($data['credits']['crew'] as $crewMember) {
                    $cartoontv->crew()->updateExistingPivot($crewMember['id'], [
                        'department' => $crewMember['department'],
                        'job'        => $crewMember['job'],
                    ]);
                }
            }
        }
    }
};
