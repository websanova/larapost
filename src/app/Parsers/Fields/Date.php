<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;
use Carbon\Carbon;

class Date
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['date'])) {
            return $data;
        }

        if (empty($parse['date'][0])) {
            throw new Exception('Date is empty.');
        }

        $data['posts'][$name]->attributes['published_at'] = Carbon::parse($parse['date'][0]);

        return $data;
    }
}