<?php

namespace Websanova\Larapost\Facades;

use Illuminate\Support\Facades\Facade;

class LarapostFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'larapost';
    }
}
