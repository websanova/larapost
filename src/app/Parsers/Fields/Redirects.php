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

            $data['posts'][$name]->redirects[]= [
                'permalink' => $redirect,
                'post'      => $data['posts'][$name],
            ];
        }

        return $data;
    }
}