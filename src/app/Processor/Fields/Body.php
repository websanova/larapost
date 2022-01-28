<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class Body
{
    public static function parse(Array $record, Array $file)
    {
        $record['body'] = $file['body'][0];

        return $record;
    }
}