<?php

namespace Websanova\Larablog;

use Request;
use Websanova\Larablog\Models\Blog;

class Larablog
{
    public static function published($page = 1, $limit = 30)
    {
        return Blog::where('published_at', '<>', 'NULL')->where('type', 'post')->orderBy('published_at', 'desc')->paginate(config('larablog.perpage'));
    }

    public static function post($slug = '')
    {
        if (empty($slug)) {
            $slug = '/' . Request::path();
        }

        $post = Blog::where('slug', $slug)->first();

        if ( ! $post) {
            return null;
        }

        if ($post->type === 'post' && $post->published_at === null) {
            return null;
        }

        return $post;
    }
}