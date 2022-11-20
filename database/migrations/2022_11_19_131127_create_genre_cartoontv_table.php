<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genre_cartoontv', function (Blueprint $table) {
            $table->unsignedInteger('genre_id');
            $table->unsignedInteger('cartoontv_id');
            $table->primary(['genre_id', 'cartoontv_id']);
        });
    }
};
