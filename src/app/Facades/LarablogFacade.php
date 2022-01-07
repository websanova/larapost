<?php

namespace Websanova\Larablog\Facades;

use Illuminate\Support\Facades\Facade;

class LarablogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'larablog';
    }
}
