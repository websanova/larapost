<?php

namespace Websanova\Larablog\Processor\Fields;

class Image
{
    public static function parse(Array $data, Array $file)
    {
        $data['meta']['image'] = $file['image'][0];

        return $data;
    }
}