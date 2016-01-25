<?php

namespace Websanova\Larablog\Parser\Field;

class Buttons
{
    public static function process($key, $val, $data)
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

        foreach ($val as $button) {
            if (preg_match('/(.*?)\:(.*)/', $button, $m)) {
                $data['meta']['buttons'][$m[1]] = $m[2];
            }
        }

        $data['meta'] = json_encode($data['meta']);

        return $data;
    }
}