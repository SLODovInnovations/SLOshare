<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class EmailBlacklistServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Add custom validation rules
        Validator::extend('blacklist', "App\Validators\EmailBlacklistValidator@validate");

        // Add custom validation messages
        Validator::replacer('blacklist', "App\Validators\EmailBlacklistValidator@message");
    }
}
