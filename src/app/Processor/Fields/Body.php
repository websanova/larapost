<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class Body
{
    public static function parse(Array $data, Array $file)
    {
        $data['body'] = $file['body'][0];

        return $data;
    }
}