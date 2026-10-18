<?php

namespace Abolaradev\Navix;

use Illuminate\Support\ServiceProvider;
use Abolaradev\Navix\Commands\NavixCommand;

class NavixServiceProvider extends ServiceProvider
{    
    /**
     * Register the navigation file
     *
     * @param  string $path
     * @return void
     */
    private function loadNavigationFrom(string $path): void 
    {
        if(file_exists($path)){
            require $path;
        }
    }

     /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Navix::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load the navigation file
        $this->loadNavigationFrom(__DIR__."/../navigation/navix.php");

        // Publishing is only available when running from the console
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Register the package Artisan commands
        $this->commands([
            NavixCommand::class
        ]);
    }
}
