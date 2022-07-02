<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Group
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['group'])) {
            return $data;
        }

        if (!isset($data['docs'][$parse['doc'][0]])) {
            throw new Exception('Doc is not set.');
        }

        if (empty($parse['group'][0])) {
            throw new Exception('Group is empty.');
        }

        $group = $parse['group'][0];

        if (!isset($data['group'][$group])) {
            $data['group'][$group] = (object)[
                'attributes' => [
                    'name' => $group,
                    'type' => 'group',
                ],
                'relations' => [
                    'doc' => $data['docs'][$parse['doc'][0]],
                ]
            ];
        }

        $data['posts'][$name]->relations['group'] = $data['group'][$group];

        return $data;
    }
}