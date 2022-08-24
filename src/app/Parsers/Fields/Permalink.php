<?php

namespace Websanova\Larapost\Parsers\Fields;

use Exception;

class Permalink
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['permalink'])) {
            throw new Exception('Permalink is required.');
        }

        $permalink = trim($parse['permalink'][0], '/');

        if (isset($data['permalinks'][$permalink])) {
            throw new Exception('Permalink is duplicate.');
        }

        $data['permalink'][$permalink] = $data['post'][$name];

        $data['post'][$name]->attributes['permalink'] = $permalink;

        return $data;
    }
}