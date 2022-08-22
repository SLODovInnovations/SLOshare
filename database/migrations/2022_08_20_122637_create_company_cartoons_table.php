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
        Schema::create('company_cartoons', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('cartoons_id');
            $table->primary(['company_id', 'cartoons_id']);
        });
    }
};
