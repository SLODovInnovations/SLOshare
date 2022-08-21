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
        Schema::create('cartoons_collection', function (Blueprint $table) {
            $table->unsignedInteger('collection_id');
            $table->unsignedInteger('cartoons_id');
            $table->primary(['collection_id', 'cartoons_id']);
        });
    }
};
