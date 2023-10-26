<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BaseRepository extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind(
        //     BaseRepositoryInterface::class,
        //     BaseRepository::class,
        // );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
