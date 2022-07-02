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
            throw new Exception('Doc is empty.');
        }

        $doc = $parse['doc'][0];

        if (!isset($data['docs'][$doc])) {
            $data['docs'][$doc] = (object)[
                'attributes' => [
                    'name' => $doc,
                    'type' => 'doc',
                ]
            ];
        }

        $data['posts'][$name]->relations['doc'] = $data['docs'][$doc];

        return $data;
    }
}