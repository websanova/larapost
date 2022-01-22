<?php

namespace Websanova\Larablog\Processor\Fields;

class Title
{
    public static function parse(Array $data, Array $file)
    {
        $data['title'] = $file['title'][0];

        $data['meta']['title'] = $file['title'][0];

        return $data;
    }
}