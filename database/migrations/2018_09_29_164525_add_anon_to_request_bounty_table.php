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
        Schema::table('request_bounty', function (Blueprint $table): void {
            $table->boolean('anon')->default(0)->after('requests_id');
        });
    }
};
