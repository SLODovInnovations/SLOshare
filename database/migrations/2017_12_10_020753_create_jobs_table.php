<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('queue');
            $table->text('payload');
            $table->boolean('attempts');
            $table->integer('reserved_at')->unsigned()->nullable();
            $table->integer('available_at')->unsigned();
            $table->integer('created_at')->unsigned();
            $table->index(['queue', 'reserved_at']);
        });
    }
};
