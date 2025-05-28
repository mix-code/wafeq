<?php

namespace MixCode\Wafeq;

use Illuminate\Support\ServiceProvider;

class WafeqServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('wafeq.php'),
            ], 'wafeq');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'wafeq');

        // Register the main class to use with the facade
        $this->app->singleton('account', fn() => new Account);
        $this->app->singleton('contact', fn() => new Contact);
        $this->app->singleton('invoice', fn() => new Invoice);
        $this->app->singleton('item', fn() => new Item);
        $this->app->singleton('manual_journal', fn() => new ManualJournal);
        $this->app->singleton('project', fn() => new Project);
        $this->app->singleton('tax_rate', fn() => new TaxRate);
    }
}
