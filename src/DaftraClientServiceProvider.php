<?php

namespace MixCode\DaftraClient;

use Illuminate\Support\ServiceProvider;

class DaftraClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('daftra-client.php'),
            ], 'daftra-client');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'daftra-client');

        // Register the main class to use with the facade
        $this->app->singleton('daftra-client', fn () => new DaftraClient);
    }
}
