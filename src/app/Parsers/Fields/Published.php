<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;
use Carbon\Carbon;

class Published
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['published'])) {
            return $data;
        }

        if (empty($parse['published'][0])) {
            throw new Exception('Published is empty.');
        }

        $data['post'][$name]->attributes['published_at'] = Carbon::parse($parse['published'][0]);

        return $data;
    }
}