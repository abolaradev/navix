<?php

namespace Abolaradev\Navix\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\warning;
use function Orchestra\Sidekick\working_path;

class NavixCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    public $signature = 'navix:install';

    /**
     * The console command description.
     */
    public $description = 'Install the Navix navigation configuration file into the application.';

    public function handle(): void
    {
        // Get the path to the default navigation configuration file.
        $navigation = working_path('navigation/navix.php');

        // Get the destination path in the application's routes directory.
        $routes = base_path('routes/navix.php');

        // Prevent overwriting an existing navigation file.
        if (File::exists($routes)) {
            warning("The navigation file already exists");
            note("at: [{$routes}]");

            return;
        }

        // Copy the default navigation file into the application's routes directory.
        File::copy($navigation, $routes);

        // Display the path of the installed navigation file.
        info("The navigation file installed successfully");
        note("at: [{$routes}]");
    }
}
