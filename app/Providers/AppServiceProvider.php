<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /**
         * If you deploy later behind HTTPS, this prevents mixed-content issues.
         * Keep it commented for local dev unless you need it.
         */
        // URL::forceScheme('https');
    }
}
