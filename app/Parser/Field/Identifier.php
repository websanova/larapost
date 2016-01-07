<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Markdown\Markdown;

class Identifier
{
    public static function process($key, $val, $data)
    {
        $data['identifier'] = $val;

        return $data;
    }
}