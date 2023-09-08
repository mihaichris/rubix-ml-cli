<?php

namespace App\Providers;

use App\Datasets\TrainingSplitter;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TrainingSplitter::class);
    }
}
