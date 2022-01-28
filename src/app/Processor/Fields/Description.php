<?php

namespace Websanova\Larablog\Processor\Fields;

class Description
{
    public static function parse(Array $record, Array $file)
    {
        $record['meta']['description'] = $file['description'][0];

        return $record;
    }
}