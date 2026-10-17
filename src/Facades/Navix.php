<?php

namespace Abolaradev\Navix\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abolaradev\Navix\Navix
 */
class Navix extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Abolaradev\Navix\Navix::class;
    }
}
