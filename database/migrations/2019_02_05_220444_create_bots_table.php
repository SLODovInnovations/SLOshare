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
        Schema::create('bots', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->integer('position');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('command');
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->string('emoji')->nullable();
            $table->string('info')->nullable();
            $table->string('about', 500)->nullable();
            $table->text('help')->nullable();
            $table->boolean('active')->default(1)->index();
            $table->boolean('is_protected')->default(0)->index();
            $table->boolean('is_triviabot')->default(0)->index();
            $table->boolean('is_nerdbot')->default(0)->index();
            $table->boolean('is_systembot')->default(0)->index();
            $table->boolean('is_casinobot')->default(0)->index();
            $table->boolean('is_betbot')->default(0)->index();
            $table->bigInteger('uploaded')->unsigned()->default(0);
            $table->bigInteger('downloaded')->unsigned()->default(0);
            $table->integer('fl_tokens')->unsigned()->default(0);
            $table->float('seedbonus', 12)->unsigned()->default(0.00);
            $table->integer('invites')->unsigned()->default(0);
            $table->timestamps();
        });
    }
};
