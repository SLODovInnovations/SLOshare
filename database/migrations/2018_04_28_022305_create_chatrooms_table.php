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
        Schema::create('chatrooms', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
    }
};
