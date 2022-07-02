<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Title
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['title'])) {
            throw new Exception('Title is required.');
        }

        if (empty($parse['title'][0])) {
            throw new Exception('Title is empty.');
        }

        $data['posts'][$name]->attributes['title'] = $parse['title'][0];

        return $data;
    }
}