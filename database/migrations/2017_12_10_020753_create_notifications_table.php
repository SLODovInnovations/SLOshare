<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table): void {
            $table->char('id', 36)->primary();
            $table->string('type');
            $table->integer('notifiable_id')->unsigned();
            $table->string('notifiable_type');
            $table->text('data', 65535);
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
            $table->index(['notifiable_id', 'notifiable_type']);
        });
    }
};
