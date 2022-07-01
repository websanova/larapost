<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

class Order
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['order'])) {
            if (isset($parse['doc'])) {
                throw new Exception('Doc requires order field.');
            }

            return $data;
        }

        if (empty($parse['doc'])) {
            throw new Exception('Order requires doc field.');
        }

        if (empty($parse['order'])) {
            throw new Exception('Order cannot be empty.');
        }

        $order = $parse['order'][0];

        $data['posts'][$name]->order = $order;

        return $data;
    }
}