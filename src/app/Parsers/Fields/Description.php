<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Description
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['description'])) {
            throw new Exception('Description is required.');
        }

        if (empty($parse['description'][0])) {
            throw new Exception('Description is empty.');
        }

        $data['posts'][$name]->description = $parse['description'][0];

        return $data;
    }
}