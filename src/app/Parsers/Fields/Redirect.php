<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Redirect
{
    public static function parse(String $name, Array $data, Array $parse)
    {

        if (!isset($parse['redirect'])) {
            return $data;
        }

        foreach ($parse['redirect'] as $redirect) {
            if (empty($redirect)) {
                throw new Exception('Redirect is empty.');
            }

            if (isset($data['permalinks'][$redirect])) {
                throw new Exception('Redirect is duplicate.');
            }

            $data['permalinks'][$redirect] = $data['posts'][$name];

            $data['posts'][$name]->relations['redirects'][]= (object)[
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