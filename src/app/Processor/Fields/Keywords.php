<?php

namespace Websanova\Larablog\Processor\Fields;

class Keywords
{
    public static function parse(Array $data, Array $file)
    {
        $data['meta']['keywords'] = $file['keywords'][0];

        return $data;
    }
}