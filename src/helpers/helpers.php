<?php

use Abolaradev\Navix\Collections\NavixCollection;
use Abolaradev\Navix\Navix;

function navix(string $batch , ?string $search = null)
{
    return app(Navix::class)->getBatch($batch , $search);
}

function navixCollect()
{
    return new NavixCollection();
}