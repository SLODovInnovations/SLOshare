<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peers', function ($table): void {
            $table->renameColumn('hash', 'info_hash');
        });
    }
};
