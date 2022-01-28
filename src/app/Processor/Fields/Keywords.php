<?php

namespace Websanova\Larablog\Processor\Fields;

class Keywords
{
    public static function parse(Array $record, Array $file)
    {
        $record['meta']['keywords'] = $file['keywords'][0];

        return $record;
    }
}