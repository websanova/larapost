<?php

namespace Websanova\Larablog\Processor\Fields;

use Carbon\Carbon;

class Date
{
    public static function parse(Array $data, Array $file)
    {
        $data['published_at'] = Carbon::parse($file['date'][0]);

        return $data;
    }
}