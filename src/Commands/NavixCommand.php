<?php

namespace Abolaradev\Navix\Commands;

use Illuminate\Console\Command;

class NavixCommand extends Command
{
    public $signature = 'navix';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
