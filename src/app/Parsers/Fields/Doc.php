<?php

namespace Websanova\Larapost\Parsers\Fields;

use Exception;
use Illuminate\Support\Str;

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

        if (!isset($data['doc'][$doc])) {
            $data['doc'][$doc] = (object)[
                'attributes' => [
                    'name' => $doc,
                    'slug' => Str::slug($doc),
                ]
            ];
        }

        $data['post'][$name]->relations['doc'] = $data['doc'][$doc];

        return $data;
    }
}