<?php

use Abolaradev\Navix\Navix;

function navix(string $batch , ?string $search = null)
{
    return app(Navix::class)->getBatch($batch , $search);
}