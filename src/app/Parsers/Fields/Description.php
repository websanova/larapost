<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Description
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (
            !isset($parse['description']) ||
            empty($parse['description'][0])
        ) {
            throw new Exception('Description is required.');
        }

        $data['posts'][$name]->description = $parse['description'][0];

        return $data;
    }
}