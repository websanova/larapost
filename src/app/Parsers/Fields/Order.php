<?php

namespace Websanova\Larapost\Parsers\Fields;

use Exception;

class Order
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['order'])) {
            if (isset($parse['doc'])) {
                throw new Exception('Order is required.');
            }

            return $data;
        }

        if (empty($parse['order'][0])) {
            throw new Exception('Order is empty.');
        }

        $data['post'][$name]->attributes['order'] = $parse['order'][0];

        return $data;
    }
}