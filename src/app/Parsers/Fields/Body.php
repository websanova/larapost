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

        if (empty($parse['body'][0])) {
            throw new Exception('Body is empty.');
        }

        $data['posts'][$name]->body = $parse['body'][0];

        return $data;
    }
}