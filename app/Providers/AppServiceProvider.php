<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        URL::forceScheme('https');

        DB::whenQueryingForLongerThan(500, static function (Connection $connection) {
            Log::warning("Database queries exceeded 5 seconds on {$connection->getName()}");

            // or notify the development team...
        });
    }
}
