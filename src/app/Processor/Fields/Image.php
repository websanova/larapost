<?php

namespace Websanova\Larablog\Processor\Fields;

class Image
{
    public static function parse(Array $record, Array $file)
    {
        $record['meta']['image'] = $file['image'][0];

        return $record;
    }
}