<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Docs
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['docs'])) {
            return $data;
        }

        if (empty($parse['docs'][0])) {
            throw new Exception('Docs is empty.');
        }

        $data['post'][$name]->attributes['docs'] = $parse['docs'][0];

        return $data;
    }
}