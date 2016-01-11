<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Models\Tag;
use Websanova\Larablog\Models\Post;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class Larablog
{
    public static function published()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->where('status', 'active')->orderBy('published_at', 'desc')->with('tags')->paginate(config('larablog.posts.perpage'));
    }

    public static function search($q = '')
    {
        if (empty($q)) {
            $q = Input::get('q');
        }

        return Post::where('published_at', '<>', 'NULL')->search($q)->where('type', 'post')->where('status', 'active')->orderBy('published_at', 'desc')->with('tags')->paginate(config('larablog.posts.perpage'));
    }

    public static function all()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->where('status', 'active')->orderBy('published_at', 'desc')->with('tags')->get();
    }

    public static function last()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->where('status', 'active')->orderBy('published_at', 'desc')->with('tags')->first();
    }

    public static function post($slug = '')
    {
        if (empty($slug)) {
            $slug = Request::path();
        }

        if ($slug[0] !== '/') {
            $slug = '/' . $slug;
        }

        $post = Post::where('slug', $slug)->with('tags')->first();

        if ($post && $post->type === 'post' && ($post->published_at === null || $post->status !== 'active') ) {
            return null;
        }

        return $post;
    }

    public static function top($amount = 10)
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->where('status', 'active')->orderBy('views_count', 'desc')->with('tags')->limit(10)->get();
    }

    public static function count()
    {
        return Post::where('published_at', '<>', 'NULL')->where('type', 'post')->where('status', 'active')->count();
    }

    public static function tags()
    {
        return Tag::orderBy('slug', 'asc')->get();
    }

    public static function publishedWhereTag($tag)
    {
        return $tag->posts()->where('published_at', '<>', 'NULL')->where('type', 'post')->where('status', 'active')->with('tags')->paginate(config('larablog.posts.perpage'));
    }
}