<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Permalink
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['permalink'])) {
            throw new Exception('Permalink is required.');
        }

        $permalink = $parse['permalink'][0];

        if (isset($data['permalinks'][$permalink])) {
            throw new Exception('Permalink is duplicate.');
        }

        $data['permalinks'][$permalink] = $data['posts'][$name];

        $data['posts'][$name]->permalink = $permalink;

        return $data;
    }
}