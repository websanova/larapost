<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Markdown\Markdown;

class Order
{
    public static function process($key, $val, $data)
    {
        $data['order'] = $val;

        return $data;
    }
}