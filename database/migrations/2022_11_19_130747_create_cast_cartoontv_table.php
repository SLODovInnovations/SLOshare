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
        Schema::create('cartoon_tv_cast', function (Blueprint $table) {
            $table->unsignedInteger('cast_id');
            $table->unsignedInteger('cartoon_tv_id');
            $table->primary(['cast_id', 'cartoon_tv_id']);
        });
    }
};
