<?php

namespace Abolaradev\Navix;

use Illuminate\Support\ServiceProvider;
use Abolaradev\Navix\Commands\NavixCommand;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;

class NavixServiceProvider extends ServiceProvider
{
     /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/navix.php',
            'navix'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publishing is only available when running from the console
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Publish the package configuration file
        $this->publishes([
            __DIR__.'/../config/navix.php' => config_path('navix.php'),
        ], ['navix', 'navix-config']);

        

        // Register the package Artisan commands
        $this->commands([
            NavixCommand::class
        ]);
    }
}
