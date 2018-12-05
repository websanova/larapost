<?php

namespace Websanova\Larablog\Parser\Field;

class Order
{
    public static function process($key, $data, $fields)
    {
        $data['order'] = !empty($fields['order']) ? $fields['order'] : 0 ;

        return $data;
    }
}