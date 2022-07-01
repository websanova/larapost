<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Doc
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['doc'])) {
            return $data;
        }

        if (empty($parse['doc'][0])) {
            throw new Exception('Doc is required.');
        }

        $doc = $parse['doc'][0];

        if (!isset($data['groups'][$doc])) {
            $data['groups'][$doc] = (object)[
                'title' => $doc,
                'type'  => 'doc',
            ];
        }

        $data['posts'][$name]->group = $data['groups'][$doc];

        return $data;
    }
}