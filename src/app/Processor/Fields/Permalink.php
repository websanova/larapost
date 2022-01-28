<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class Permalink
{
    public static function parse(Array $record, Array $file)
    {
        $record['permalink'] = '/' . trim($file['permalink'][0], '/');

        return $record;
    }
}