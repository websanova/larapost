<?php

namespace Websanova\Larablog\Processor\Fields;

class Permalink
{
    public static function parse(Array $data, Array $file)
    {
        $data['key'] = $file['permalink'][0];

        $data['permalink'] = $data['key'];

        return $data;
    }
}