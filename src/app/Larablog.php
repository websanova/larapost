<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Parsers\LarablogParser;

class Larablog
{
    public static function build()
    {
        $data = self::diff();
    }


    public static function diff()
    {
        return LarablogParser::handle();
    }



    // // Checking for redirects (middleware).

    // // Larablog::post()->build() // output into array for printing.
    // // Larablog::doc()->build() // output into array for printing.

    // // Larablog::post()->paginate($per_page);
    // // Larablog::doc()->paginate($per_page);

    // // $post = Larablog::post()->find($id);
    // // $post = Larablog::doc()->find($id);

    // // find, redirect, fail

    // // $post->next();
    // // $post->prev();


    // // Tags

    // public static function tag(String $slug)
    // {

    // }

    // public static function tags()
    // {

    // }

    // public static function serie(String $slug)
    // {

    // }

    // public static function series()
    // {

    // }

    // public static function doc(String $slug)
    // {

    // }

    // public static function docs()
    // {

    // }

    // // Posts

    // public static function post(String $slug)
    // {
    //     $slug = '/' . trim($slug, '/');
    //     $post = config('larablog.models.post');
    //     $key  = config('larablog.keys.' . $post);

    //     return $post::query()
    //         ->where('type', 'post')
    //         ->where($key, $slug)
    //         ->first();
    // }

    // public static function posts()
    // {
    //     $post = config('larablog.models.post');

    //     return $post::query()
    //         ->where('type', 'post')
    //         ->paginate();
    // }

    // //

    // public static function processor()
    // {
    //     return new Processor;
    // }
}
