<?php

namespace App\Providers;

use App\Actions\NewsRetrievalHandler;
use App\Actions\Source\SourceManager;
use Illuminate\Contracts\Foundation\Application;
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
        //
    }
}
