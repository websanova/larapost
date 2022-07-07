<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Parsers\LarablogParser;

class Larablog
{
    public static function build()
    {
        $models = config('larablog.models');
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

    public static function docs()
    {

    }
}
