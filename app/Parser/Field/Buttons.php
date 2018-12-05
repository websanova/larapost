<?php

namespace Websanova\Larablog\Parser\Field;

class Buttons
{
    public static function process($key, $data, $fields)
    {
        if ( ! isset($data['meta'])) {
            $data['meta'] = [];
        }
        else {
            $data['meta'] = (array)json_decode($data['meta']);
        }

        if ( ! isset($data['meta']['buttons'])) {
            $data['meta']['buttons'] = [];
        }

        if ( ! empty($fields['buttons'])) {
            foreach ($fields['buttons'] as $button) {
                array_push($data['meta']['buttons'], json_decode($button));
            }
        }

        $data['meta'] = json_encode($data['meta']);

        return $data;
    }
}