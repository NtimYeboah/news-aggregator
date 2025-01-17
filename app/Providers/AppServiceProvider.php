<?php

namespace App\Providers;

use App\Actions\NewsRetrievalHandler;
use App\Source\SourceManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsRetrievalHandler::class, function (Application $app) {
            return new NewsRetrievalHandler($app->make(SourceManager::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
