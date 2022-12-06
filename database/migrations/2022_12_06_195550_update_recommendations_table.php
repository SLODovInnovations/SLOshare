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
        Schema::table('recommendations', function (Blueprint $table) {
            $table->unsignedBigInteger('cartoontv_id')->nullable()->index();
            $table->foreign('cartoontv_id')->references('id')->on('cartoontv')->onDelete('cascade');

            $table->unsignedBigInteger('recommendation_cartoontv_id')->nullable()->index();
            $table->foreign('recommendation_cartoontv_id')->references('id')->on('cartoontv')->onDelete('cascade');

            $table->unique(['cartoontv_id', 'recommendation_cartoontv_id']);
        });
    }
};
