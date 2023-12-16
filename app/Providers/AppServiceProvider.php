<?php

namespace App\Providers;

use App\Datasets\TrainingSplitter;
use App\Persisters\ModelLoader;
use App\Persisters\ModelPersister;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TrainingSplitter::class);
        $this->app->singleton(ModelPersister::class);
        $this->app->singleton(ModelLoader::class);
    }
}
