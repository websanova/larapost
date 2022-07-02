<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Redirects
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['redirects'])) {
            return $data;
        }

        foreach ($parse['redirects'] as $redirect) {
            if (empty($redirect)) {
                throw new Exception('Redirect is empty.');
            }

            if (isset($data['permalinks'][$redirect])) {
                throw new Exception('Redirect is duplicate.');
            }

            $data['permalinks'][$redirect] = $data['posts'][$name];

            $data['posts'][$name]->relations['redirects'][]= [
                'attributes' => [
                    'permalink' => $redirect,
                ],
                'relations' => [
                    'post' => $data['posts'][$name],
                ]
            ];
        }

        return $data;
    }
}