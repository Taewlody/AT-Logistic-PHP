<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use File;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
            
            File::append(
                storage_path('/logs/query.log'),
                '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
            );
        });
    }
}
