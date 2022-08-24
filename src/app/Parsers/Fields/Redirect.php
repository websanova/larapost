<?php

namespace Websanova\Larapost\Parsers\Fields;

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

            $redirect = trim($redirect, '/');

            if (isset($data['permalinks'][$redirect])) {
                throw new Exception('Redirect is duplicate.');
            }

            $data['permalink'][$redirect] = $data['post'][$name];

            $data['post'][$name]->relations['redirects'][]= (object)[
                'attributes' => [
                    'permalink' => $redirect,
                ],
                'relations' => [
                    'post' => $data['post'][$name],
                ]
            ];
        }

        return $data;
    }
}