<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Parsers\LarablogParser;

class Larablog
{
    public static function build()
    {
        // Parse

        $parser = config('larablog.parser');
        $data   = $parser::parse();

        // Error

        if (isset($data['errors'])) {
            return [
                'data'   => $data,
                'status' => 'error',
            ];
        }

        // Build

        $models = config('larablog.models');

        foreach ($models as $key => $model) {
            if (isset($data[$key])) {
                $model::build($data[$key]);
            }
        }

        // Success

        return [
            'data'   => $data,
            'status' => 'success',
        ];
    }
}
