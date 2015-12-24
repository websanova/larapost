<?php

namespace Websanova\Larablog;

use Illuminate\Support\Facades\Facade;

class LarablogFacade extends Facade
{
    protected static function getFacadeAccessor()
    { 
        return 'larablog';
    }
}
