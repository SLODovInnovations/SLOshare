<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recommendations', function (Blueprint $table) {
            $table->foreignId('cartoons_id')->constrained();
            $table->foreignId('recommendation_cartoons_id')->constrained();

            $table->unique(['cartoons_id', 'recommendation_cartoons_id']);
        });
    }
};