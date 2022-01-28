<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class BodyRaw
{
    public static function parse(Array $record, Array $file)
    {
        $body       = $file['body-raw'][0];
        $searchable = $record['searchable'] ?? '';

        $record['searchable'] = str_replace('-', ' ', Str::slug($body . ' ' . $searchable));

        return $record;
    }
}