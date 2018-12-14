<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Models\Doc;
use Websanova\Larablog\Models\Tag;
use Websanova\Larablog\Models\Post;
use Websanova\Larablog\Models\Serie;

class Larablog
{
    public static function searchPosts($q = '')
    {
        if (empty($q)) {
            $q = request()->get('q');
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

    public static function relatedPosts(Post $post, $limit = 6)
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

    public static function posts()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->paginate();
    }

    public static function post($slug = '')
    {
        if (empty($slug)) {
            $slug = '/' . request()->path();
        }

        $post = Post::query()
            ->where('permalink', $slug)
            ->with('tags', 'serie')
            ->first();

        // if ($post && $post->type === 'post' && ($post->published_at === null || $post->deleted_at !== null) ) {
        //     return null;
        // }

        return $post;
    }

    public static function lastPost()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->orderBy('published_at', 'desc')
            ->first();
    }

    public static function firstPost($series)
    {
        return Post::query()
            ->where('serie_id', $series->id)
            ->orderBy('order', 'asc')
            ->first();
    }

    public static function topPosts($amount = 10)
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
    }

    public static function allPosts()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->get();
    }

    public static function tagPosts($tag)
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

    public static function seriesPosts($serie)
    {
        return $serie
            ->posts()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->paginate(config('larablog.posts.perpage'));
    }

    public static function docPosts($doc)
    {
        return $doc
            ->posts()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'doc')
            ->with('tags', 'posts')
            ->paginate(config('larablog.posts.perpage'));
    }

    public static function countPosts()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->count();
    }

    public static function allPages()
    {
        return Post::query()
            ->where('type', 'page')
            ->whereNull('deleted_at')
            ->orderBy('title', 'asc')
            ->get();
    }

    public static function tag($slug = '')
    {
        if (empty($slug)) {
            $slug = request()->route()->parameter('slug');
        }

        return Tag::where('slug', $slug)->first();
    }

    public static function allTags()
    {
        return Tag::query()
            ->orderBy('slug', 'asc')
            ->get();
    }

    public static function allSeries()
    {
        return Serie::query()
            ->where('type', 'series')
            ->orderBy('slug', 'asc')
            ->with('posts.tags', 'posts.serie')
            ->get();
    }

    public static function series($slug = '')
    {
        if (empty($slug)) {
            $slug = request()->route()->parameter('slug');
        }

        $series = Serie::query()
            ->where('type', 'series')
            ->where('slug', $slug)
            ->first();

        return $series;
    }

    public static function allDocs()
    {
        return Serie::query()
            ->where('type', 'docs')
            ->orderBy('slug', 'asc')
            ->get();
    }

    public static function doc($slug = '')
    {
        if (empty($slug)) {
            $slug = request()->route()->parameter('slug');
        }

        $doc = Serie::query()
            ->where('type', 'docs')
            ->where('slug', $slug)
            ->with('posts')
            ->first();

        return $doc;
    }
}