<?php

namespace Websanova\Larapost;

use Websanova\Larapost\Parsers\LarapostParser;

class Larapost
{
    public static function build()
    {
        // Parse

        $parser = config('larapost.parser');
        $data   = $parser::parse();

        // Error

        if (isset($data['errors'])) {
            return [
                'data'   => $data,
                'status' => 'error',
            ];
        }

        // Build

        $models = config('larapost.models');

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
