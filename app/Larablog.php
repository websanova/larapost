<?php

namespace Websanova\Larablog;

use Input;
use Request;
use Websanova\Larablog\Models\Post;

class Larablog
{
    public static function published()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->paginate(config('larablog.perpage'));
    }

    public static function search($q = '')
    {
        if (empty($q)) {
            $q = Input::get('q');
        }

        return Post::where('published_at', '<>', 'NULL')->search($q)->where('type', 'post')->orderBy('published_at', 'desc')->paginate(config('larablog.perpage'));
    }

    public static function all()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->get();
    }

    public static function last()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->first();
    }

    public static function post($slug = '')
    {
        if (empty($slug)) {
            $slug = Request::path();
        }

        if ($slug[0] !== '/') {
            $slug = '/' . $slug;
        }

        $post = Post::where('slug', $slug)->first();

        if ($post && $post->type === 'post' && $post->published_at === null) {
            return null;
        }

        return $post;
    }

    public static function count()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->count();
    }
}