<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warnings', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->index('warnings_user_id_foreign');
            $table->integer('warned_by')->index('warnings_warned_by_foreign');
            $table->bigInteger('torrent')->unsigned()->index('warnings_torrent_foreign');
            $table->text('reason', 65535);
            $table->dateTime('expires_on')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });
    }
};
