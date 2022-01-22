<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class BodyRaw
{
    public static function parse(Array $data, Array $file)
    {
        $data['searchable'] = str_replace('-', ' ', Str::slug($file['body-raw'][0]));

        return $data;
    }
}