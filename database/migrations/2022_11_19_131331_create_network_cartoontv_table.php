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
        Schema::create('cartoon_tv_network', function (Blueprint $table): void {
            $table->unsignedInteger('network_id');
            $table->unsignedInteger('cartoon_tv_id');
            $table->primary(['network_id', 'cartoon_tv_id']);
        });
    }
};
