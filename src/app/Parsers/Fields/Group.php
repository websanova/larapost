<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;
use Illuminate\Support\Str;

class Group
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['group'])) {
            return $data;
        }

        if (!isset($data['doc'][$parse['doc'][0]])) {
            throw new Exception('Doc is not set.');
        }

        if (empty($parse['group'][0])) {
            throw new Exception('Group is empty.');
        }

        $group = $parse['group'][0];
        $key   = $parse['doc'][0] . ' : ' . $parse['group'][0];

        if (!isset($data['group'][$key])) {
            $data['group'][$key] = (object)[
                'attributes' => [
                    'name' => $group,
                    'slug' => Str::slug($group),
                ],
                'relations' => [
                    'doc' => $data['doc'][$parse['doc'][0]],
                ]
            ];
        }

        $data['post'][$name]->relations['group'] = $data['group'][$key];

        return $data;
    }
}