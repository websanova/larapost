<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;
use Illuminate\Support\Str;

class Body
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['body'])) {
            throw new Exception('body is required.');
        }

        $data['posts'][$name]->body = $parse['body'][0];

        return $data;
    }
}