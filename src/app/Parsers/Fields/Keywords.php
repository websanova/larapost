<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Keywords
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (
            !isset($parse['keywords']) ||
            empty($parse['keywords'][0])
        ) {
            throw new Exception('Keywords is required.');
        }

        $data['posts'][$name]->keywords = $parse['keywords'][0];

        return $data;
    }
}