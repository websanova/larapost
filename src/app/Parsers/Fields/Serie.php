<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Serie
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['serie'])) {
            return $data;
        }

        if (empty($parse['serie'])) {
            throw new Exception('Serie cannot be empty.');
        }

        $serie = $parse['serie'][0];

        if (!isset($data['groups'][$serie])) {
            $data['groups'][$serie] = (object)[
                'title' => $serie,
                'type'  => 'serie',
            ];
        }

        $data['posts'][$name]->group = $data['groups'][$serie];

        return $data;
    }
}