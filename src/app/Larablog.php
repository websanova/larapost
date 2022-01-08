<?php

namespace Websanova\Larablog;

class Larablog
{
    // Checking for redirects (middleware).

    // Larablog::post()->build() // output into array for printing.
    // Larablog::doc()->build() // output into array for printing.

    // Larablog::post()->paginate($per_page);
    // Larablog::doc()->paginate($per_page);

    // $post = Larablog::post()->find($id);
    // $post = Larablog::doc()->find($id);

    // find, redirect, fail

    // $post->next();
    // $post->prev();

    protected static function make($method)
    {
        $class = '\\Websanova\\Larablog\\Models\\' . ucfirst($method);

        return new $class;
    }

    public static function __callStatic($method, $args)
    {
        return self::make($method);
    }

    public function __call($method, $args)
    {
        return self::make($method);
    }
}
