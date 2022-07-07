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

    public static function doc(String $slug)
    {
        return config('larablog.models.doc')::whereFirst('slug', $slug);
    }

    public static function docs()
    {
        return config('larablog.models.doc')::get();
    }

    public static function serie(String $slug)
    {
        return config('larablog.models.serie')::whereFirst('slug', $slug);
    }

    public static function series()
    {
        return config('larablog.models.serie')::get();
    }

    public static function tag(String $slug)
    {
        return config('larablog.models.tag')::whereFirst('slug', $slug);
    }

    public static function tags()
    {
        return config('larablog.models.tag')::get();
    }
}
