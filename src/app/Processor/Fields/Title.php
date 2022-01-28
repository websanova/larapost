<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class Title
{
    public static function parse(Array $record, Array $file)
    {
        $title      = $file['title'][0];
        $searchable = $record['searchable'] ?? '';

        $record['searchable']    = str_replace('-', ' ', Str::slug($title . ' ' . $searchable));
        $record['title']         = $title;
        $record['meta']['title'] = $title;

        return $record;
    }
}