<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;
use Carbon\Carbon;

class Updated
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['updated'])) {
            return $data;
        }

        if (empty($parse['updated'][0])) {
            throw new Exception('Updated is empty.');
        }

        $data['post'][$name]->attributes['updated_at'] = Carbon::parse($parse['updated'][0]);

        return $data;
    }
}