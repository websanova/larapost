<?php

namespace Websanova\Larapost\Parsers\Fields;

use Exception;

class Release
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['release'])) {
            return $data;
        }

        if (empty($parse['release'][0])) {
            throw new Exception('Release is empty.');
        }

        $data['post'][$name]->attributes['release'] = $parse['release'][0];

        return $data;
    }
}