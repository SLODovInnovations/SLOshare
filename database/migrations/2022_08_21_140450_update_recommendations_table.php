<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            $table->unsignedBigInteger('cartoons_id')->nullable()->index();
            $table->foreign('cartoons_id')->references('id')->on('cartoons')->onDelete('cascade'));

            $table->unsignedBigInteger('recommendation_cartoons_id')->nullable()->index();
            $table->foreign('recommendation_cartoons_id')->references('id')->on('cartoons')->onDelete('cascade');

            $table->unique(['cartoons_id', 'recommendation_cartoons_id']);
        });
    }
};