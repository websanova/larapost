<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Parsers\LarablogParser;

class Larablog
{
    public static function build()
    {
        $models = config('larablog.models');
        $parser = config('larablog.parser');
        $data   = $parser::getData();

        //

        foreach ($models as $model) {
            $model::truncate();

            $table =  (new $model)->getTable();

            echo $table;

            break;


        }



        // //

        // $c_doc   = config('larablog.models.doc');
        // $c_group = config('larablog.models.group');
        // $c_post  = config('larablog.models.post');
        // $c_serie = config('larablog.models.serie');
        // $c_tag   = config('larablog.models.tag');

        // //

        // $c_doc::truncate();
        // $c_group::truncate();
        // $c_post::truncate();
        // $c_serie::truncate();
        // $c_tag::truncate();

        // foreach ($data['posts'] as $post) {

        //     unset($post->doc);
        //     unset($post->group);
        //     unset($post->serie);
        //     unset($post->tags);
        //     unset($post->redirects);

        //     print_r((array)$post);

        //     $c_post::create((array)$post);

        //     // $model = new $c_post;

        //     // $model->fill($post);
        // }


    }

    public static function diff()
    {
        $parser = config('larablog.parser');
        $data   = $parser::getData();

        //

        $doc   = config('larablog.models.doc');
        $group = config('larablog.models.group');
        $post  = config('larablog.models.post');
        $serie = config('larablog.models.serie');
        $tag   = config('larablog.models.tag');

        //

        $cur_docs   = $doc::get();
        $cur_groups = $group::get();
        $cur_posts  = $post::with('doc', 'group', 'serie', 'tags', 'redirects')->get();
        $cur_series = $serie::get();
        $cur_tags   = $tag::get();

        $raw_posts  = collect();

        //

        foreach ($data['posts'] as $post) {
            $class = config('larablog.models.post');

            $model = new $class;

            $model->fill([
                'permalink' => $post->permalink,
                'title'     => $post->title,
            ]);

            $raw_posts->push($model);
        }

        $permalinks = $raw_posts->pluck('permalink')->toArray();

        $new = $cur_posts->filter(function($post) use ($permalinks) {
            return !in_array($post->permalink, $permalinks);
        });

        print_r($new);





        $permalinks = $cur_posts->pluck('permalink')->toArray();

        $del = $raw_posts->filter(function($post) use ($permalinks) {
            return !in_array($post->permalink, $permalinks);
        });

        print_r($del);









        // $posts  = $post::get();
        // $tags   = $tag::get();



        return $data;
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
