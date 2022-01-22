<?php

namespace Websanova\Larablog\Processor\Fields;

class Redirect
{
    public static function parse(Array $data, Array $file)
    {
        foreach($file['redirect'] as $redirect) {
            $data['relations']['redirects'][]= [
                'body'      => $file['permalink'][0],
                'permalink' => $redirect,
                'type'      => 'redirect'
            ];
        }

        return $data;
    }
}