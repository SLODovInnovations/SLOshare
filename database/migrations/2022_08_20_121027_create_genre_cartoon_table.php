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
        Schema::create('cartoon_genre', function (Blueprint $table): void {
            $table->unsignedInteger('genre_id');
            $table->unsignedInteger('cartoon_id');
            $table->primary(['genre_id', 'cartoon_id']);
        });
    }
};
