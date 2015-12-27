<?php

namespace Websanova\Larablog;

use Input;
use Request;
use Websanova\Larablog\Models\Blog;

class Larablog
{
    public static function published()
    {
        return Blog::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->paginate(config('larablog.perpage'));
    }

    public static function search($q = '')
    {
        if (empty($q)) {
            $q = Input::get('q');
        }

        return Blog::where('published_at', '<>', 'NULL')->search($q)->where('type', 'post')->orderBy('published_at', 'desc')->paginate(config('larablog.perpage'));
    }

    public static function all()
    {
        return Blog::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->get();
    }

    public static function last()
    {
        return Blog::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->first();
    }

    public static function post($slug = '')
    {
        if (empty($slug)) {
            $slug = Request::path();
        }

        if ($slug[0] !== '/') {
            $slug = '/' . $slug;
        }

        $post = Blog::where('slug', $slug)->first();

        if ($post && $post->type === 'post' && $post->published_at === null) {
            return null;
        }

        return $post;
    }

    public static function count()
    {
        return Blog::where('published_at', '<>', 'NULL')->where('type', 'post')->count();
    }
}