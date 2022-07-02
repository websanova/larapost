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
            throw new Exception('Serie is empty.');
        }

        $serie = $parse['serie'][0];

        if (!isset($data['series'][$serie])) {
            $data['series'][$serie] = (object)[
                'attributes' => [
                    'name' => $serie,
                    'type' => 'serie',
                ]
            ];
        }

        $data['posts'][$name]->relations['serie'] = $data['series'][$serie];

        return $data;
    }
}