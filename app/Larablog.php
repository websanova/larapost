<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Models\Doc;
use Websanova\Larablog\Models\Tag;
use Websanova\Larablog\Models\Post;
use Websanova\Larablog\Models\Serie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class Larablog
{
    public static function published()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->paginate(config('larablog.posts.perpage'));
    }

    public static function search($q = '')
    {
        if (empty($q)) {
            $q = Input::get('q');
        }

        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->search($q)
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->paginate(config('larablog.posts.perpage'));
    }

    public static function related(Post $post, $limit = 6)
    {
        $q = Post::query()
            ->selectRaw("*, MATCH(title, body) AGAINST(?) AS score", [$post->title])
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->search($post->title)
            ->where('type', 'post')
            ->where('id', '<>', $post->id)
            ->with('tags', 'serie')
            ->orderBy('score', 'desc')
            ->limit($limit);

        if ((int)$post->serie_id > 0) {
            $q->where('serie_id', '<>', $post->serie_id);
        }

        return $q->get();
    }

    public static function allPosts()
    {
        return self::posts(10000);
    }

    public static function posts($limit = null)
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->paginate($limit);
    }

    public static function pages()
    {
        return Post::query()
            ->where('type', 'page')
            ->whereNull('deleted_at')
            ->orderBy('title', 'asc')
            ->get();
    }

    public static function last()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->orderBy('published_at', 'desc')
            ->first();
    }

    public static function post($slug = '')
    {
        if (empty($slug)) {
            $slug = Request::path();
        }

        if ($slug[0] !== '/') {
            $slug = '/' . $slug;
        }

        $post = Post::query()
            ->where('permalink', $slug)
            ->with('tags', 'serie')
            ->first();

        if ($post && $post->type === 'post' && ($post->published_at === null || $post->deleted_at !== null) ) {
            return null;
        }

        return $post;
    }

    public static function top($amount = 10)
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
    }

    public static function count()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->count();
    }

    public static function tags()
    {
        return Tag::query()
            ->orderBy('slug', 'asc')
            ->get();
    }

    public static function publishedWhereTag($tag)
    {
        return $tag
            ->posts()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->paginate(config('larablog.posts.perpage'));
    }

    public static function series()
    {
        return Serie::query()
            ->where('type', 'series')
            ->orderBy('slug', 'asc')
            ->with('posts.tags', 'posts.serie')
            ->get();
    }

    public static function publishedWhereSeries($serie)
    {
        return $serie
            ->posts()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->paginate(config('larablog.posts.perpage'));
    }

    public static function docs()
    {
        return Serie::query()
            ->where('type', 'docs')
            ->orderBy('slug', 'asc')
            ->get();
    }

    public static function doc($slug)
    {
        return Serie::query()
            ->where('type', 'docs')
            ->where('slug', $slug)
            ->with('posts')
            ->first();
    }
}