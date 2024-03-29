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
        Schema::create('application_url_proofs', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('application_id')->index();
            $table->string('url');
            $table->timestamps();
        });
    }
};
