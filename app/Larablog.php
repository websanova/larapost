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

    public static function posts()
    {
        return Post::query()
            ->whereNull('deleted_at')
            ->whereNotNull('published_at')
            ->where('type', 'post')
            ->with('tags', 'serie')
            ->orderBy('published_at', 'desc')
            ->get();
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
            ->where('slug', $slug)
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

    public static function chapters($doc)
    {
        return new \Illuminate\Database\Eloquent\Collection([
            (object)[
                'slug' => '/docs/vue-upload/chapter-one',
                'url' => route('docs') . '/vue-upload/chapter-one',
                'title' => 'Chapter One',
                'sections' => new \Illuminate\Database\Eloquent\Collection([
                    (object)[
                        'url' => route('docs') . '/vue-upload/chapter-one#section-one',
                        'title' => 'Section One',
                        'slug' => 'section-one'
                    ],
                    (object)[
                        'url' => route('docs') . '/vue-upload/chapter-one#section-two',
                        'title' => 'Section Two',
                        'slug' => 'section-two'
                    ],
                    (object)[
                        'url' => route('docs') . '/vue-upload/chapter-one#section-three',
                        'title' => 'Section Three',
                        'slug' => 'section-three'
                    ],
                    (object)[
                        'url' => route('docs') . '/vue-upload/chapter-one#section-four',
                        'title' => 'Section Four',
                        'slug' => 'section-four'
                    ],
                    (object)[
                        'url' => route('docs') . '/vue-upload/chapter-one#section-five',
                        'title' => 'Section Five',
                        'slug' => 'section-five'
                    ]
                ])
            ],
            (object) [
                'slug' => '/docs/vue-upload/chapter-two',
                'url' => route('docs') . '/vue-upload/chapter-two',
                'title' => 'Chapter Two',
                'sections' => new \Illuminate\Database\Eloquent\Collection([
                    (object)[
                        // 'slug' => '/docs/vue-upload/chapter-one',
                        'url' => route('docs') . '/vue-upload/chapter-two#section-one',
                        'title' => 'Section One',
                        'slug' => 'section-one'
                    ]
                ])
            ],
            (object) [
                'slug' => '/docs/vue-upload/methods',
                'url' => route('docs') . '/vue-upload/methods',
                'title' => 'Methods',
                'sections' => new \Illuminate\Database\Eloquent\Collection([
                    (object)[
                        'url' => route('docs') . '/vue-upload/methods#on',
                        'title' => 'on()',
                        'slug' => 'on'
                    ],
                    (object)[
                        'url' => route('docs') . '/vue-upload/methods#reset',
                        'title' => 'reset()',
                        'slug' => 'reset'
                    ]
                ])
            ],
            (object) [
                'slug' => '/docs/vue-upload/options',
                'url' => route('docs') . '/vue-upload/options',
                'title' => 'Options',
                'sections' => new \Illuminate\Database\Eloquent\Collection([
                    (object)[
                        'url' => route('docs') . '/vue-upload/options#multiple',
                        'title' => 'multiple',
                        'slug' => 'multiple'
                    ],
                    (object)[
                        'url' => route('docs') . '/vue-upload/options#something',
                        'title' => 'something',
                        'slug' => 'something'
                    ]
                ])
            ]
        ]);
    }
}