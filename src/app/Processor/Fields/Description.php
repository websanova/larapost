<?php

namespace Websanova\Larablog\Processor\Fields;

class Description
{
    public static function parse(Array $data, Array $file)
    {
        $data['meta']['description'] = $file['description'][0];

        return $data;
    }
}