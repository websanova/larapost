<?php

namespace Websanova\Larablog\Processor\Fields;

use Carbon\Carbon;

class Date
{
    public static function parse(Array $record, Array $file)
    {
        $record['published_at'] = Carbon::parse($file['date'][0]);

        return $record;
    }
}