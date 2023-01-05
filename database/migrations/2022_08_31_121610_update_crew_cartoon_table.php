<?php

use App\Models\Cartoon;
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
        Schema::table('crew_cartoon', function (Blueprint $table) {
            $table->string('department')->nullable();
            $table->string('job')->nullable();
        });

        foreach (Cartoon::all() as $cartoon) {
            $crew = (new \App\Services\Tmdb\Client\Cartoon($cartoon->id))->get_crew();

            if (isset($crew)) {
                foreach ($crew as $crewMember) {
                    $cartoon->crew()->updateExistingPivot($crewMember['id'], [
                        'department' => $crewMember['department'],
                        'job'        => $crewMember['job'],
                    ]);
                }
            }
        }
    }
};
