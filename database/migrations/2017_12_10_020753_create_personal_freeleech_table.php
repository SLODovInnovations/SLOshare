<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_freeleech', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->timestamps();
        });
    }
};
