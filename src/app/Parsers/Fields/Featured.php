<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Featured
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['featured'])) {
            return $data;
        }

        if (empty($parse['featured'][0])) {
            throw new Exception('Featured is empty.');
        }

        $data['post'][$name]->attributes['featured'] = $parse['featured'][0];

        return $data;
    }
}