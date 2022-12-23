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
            $table->unsignedBigInteger('cartoon_tv_id')->nullable()->index();
            $table->foreign('cartoon_tv_id')->references('id')->on('cartoon_tv')->onDelete('cascade');

            $table->unsignedBigInteger('recommendation_cartoon_tv_id')->nullable()->index();
            $table->foreign('recommendation_cartoon_tv_id')->references('id')->on('cartoon_tv')->onDelete('cascade');

            $table->unique(['cartoon_tv_id', 'recommendation_cartoon_tv_id']);
        });
    }
};
