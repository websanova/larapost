<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Image
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['image'])) {
            return $data;
        }

        if (empty($parse['image'][0])) {
            throw new Exception('Image is empty.');
        }

        $data['post'][$name]->attributes['image'] = $parse['image'][0];

        return $data;
    }
}