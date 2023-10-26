<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OpenAIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('openai', function ($app) {
            return new \App\Services\OpenAIService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
