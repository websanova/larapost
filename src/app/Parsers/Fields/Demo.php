<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Demo
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['demo'])) {
            return $data;
        }

        if (empty($parse['demo'][0])) {
            throw new Exception('Demo is empty.');
        }

        $data['post'][$name]->attributes['demo'] = $parse['demo'][0];

        return $data;
    }
}