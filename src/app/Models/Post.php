<?php

namespace Websanova\Larapost\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $casts = [
        'meta' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larapost.table.prefix') . 'posts';
    }

    public function doc()
    {
        return $this->belongsTo(config('larapost.models.doc'));
    }

    public function group()
    {
        return $this->belongsTo(config('larapost.models.group'));
    }

    public function redirect()
    {
        return $this->belongsTo(config('larapost.models.post'), 'redirect_id');
    }

    public function redirects()
    {
        return $this->hasMany(config('larapost.models.post'), 'redirect_id');
    }

    public function serie()
    {
        return $this->belongsTo(config('larapost.models.serie'));
    }

    public function tags()
    {
        return $this->belongsToMany(config('larapost.models.tag'));
    }

    public static function build(Array $posts = [])
    {
        self::truncate();

        foreach ($posts as $post) {
            if (isset($post->relations['doc'])) {
                $post->attributes['doc_id'] = $post->relations['doc']->model->id;
            }

            if (isset($post->relations['serie'])) {
                $post->attributes['serie_id'] = $post->relations['serie']->model->id;
            }

            if (isset($post->relations['group'])) {
                $post->attributes['group_id'] = $post->relations['group']->model->id;
            }

            $post->model = self::create($post->attributes);

            // Tags

            if (isset($post->relations['tags'])) {
                $ids = [];

                foreach ($post->relations['tags'] as $tag) {
                    $ids[]= $tag->model->id;
                }

                $post->model->tags()->sync($ids);
            }

            // Redirects

            if (isset($post->relations['redirects'])) {
                foreach ($post->relations['redirects'] as $redirect) {
                    $redirect->attributes['redirect_id'] = $post->model->id;

                    $redirect->model = self::create($redirect->attributes);
                }
            }
        }
    }

    public function nextPageUrl()
    {
        if ($this->is_doc) {
            $post = $this->doc
                ->posts()
                ->isDoc()
                ->orderBy('order')
                ->where('order', '>', $this->order)
                ->first();
        }
        else {
            $post = self::query()
                ->isPost()
                ->orderBy('published_at', 'desc')
                ->where('published_at', '<=', $this->published_at)
                ->where('id', '<>', $this->id)
                ->first();
        }

        return $post->url ?? null;
    }

    public function previousPageUrl()
    {
        if ($this->is_doc) {
            $post = $this->doc->posts()
                ->isDoc()
                ->orderBy('order', 'desc')
                ->where('order', '<', $this->order)
                ->first();
        }
        else {
            $post = self::query()
                ->isPost()
                ->orderBy('published_at', 'asc')
                ->where('published_at', '>=', $this->published_at)
                ->where('id', '<>', $this->id)
                ->first();
        }

        return $post->url ?? null;
    }

    public function nextPageSerieUrl()
    {
        $post = $this->serie
            ->posts()
            ->isPost()
            ->orderBy('order')
            ->where('order', '>', $this->order)
            ->first();

        return $post->url ?? null;
    }

    public function previousPageSerieUrl()
    {
        $post = $this->serie
            ->posts()
            ->isPost()
            ->orderBy('order', 'desc')
            ->where('order', '<', $this->order)
            ->first();

        return $post->url ?? null;
    }

    public function nextPageTagUrl(Tag $tag)
    {
        $post = $tag->posts()
            ->isPost()
            ->orderBy('published_at', 'desc')
            ->where('published_at', '<=', $this->published_at)
            ->where('id', '<>', $this->id)
            ->first();

        return $post->url ?? null;
    }

    public function previousPageTagUrl(Tag $tag)
    {
        $post = $tag->posts()
            ->isPost()
            ->orderBy('published_at', 'asc')
            ->where('published_at', '>=', $this->published_at)
            ->where('id', '<>', $this->id)
            ->first();

        return $post->url ?? null;
    }

    public function nextPageQueryUrl(String $query)
    {
        $post = self::query()
            ->isPost()
            ->search($query)
            ->orderBy('published_at', 'desc')
            ->where('published_at', '<=', $this->published_at)
            ->where('id', '<>', $this->id)
            ->first();

        return $post->url ?? null;
    }

    public function previousPageQueryUrl(String $query)
    {
        $post = self::query()
            ->isPost()
            ->search($query)
            ->orderBy('published_at', 'asc')
            ->where('published_at', '>=', $this->published_at)
            ->where('id', '<>', $this->id)
            ->first();

        return $post->url ?? null;
    }

    public function related(Int $limit = 5)
    {
        $q = Post::query()
            ->isPost()
            ->selectRaw('*, MATCH(`searchable`) AGAINST(?) AS score', [$this->title])
            ->search($this->title)
            ->where('id', '<>', $this->id)
            ->orderBy('score', 'desc')
            ->limit($limit);

        if ($this->serie_id > 0) {
            $q->where(function ($q) {
                $q->whereNull('serie_id')
                  ->orWhere('serie_id', '<>', $this->serie_id);
            });
        }

        return $q->get();
    }

    public function scopeIsDoc($q)
    {
        $q->where('doc_id', '<>', 0);
        $q->where('redirect_id', 0);
    }

    public function scopeIsFeatured($q)
    {
        $q->where('featured', '<>', 0);
    }

    public function scopeIsPost($q)
    {
        $q->where('doc_id', 0);
        $q->where('redirect_id', 0);
    }

    public function scopeIsRedirect($q)
    {
        $q->where('redirect_id', '<>', 0);
    }

    public function scopeSearch($q, String $query = null)
    {
        $query = trim($query);

        if (!empty($query)) {
            $q->whereRaw("MATCH (searchable) AGAINST (? IN BOOLEAN MODE)", [$query]);
        }
    }

    public function getIsDocAttribute()
    {
        return $this->doc_id !== 0 && $this->redirect_id === 0;
    }

    public function getIsPostAttribute()
    {
        return $this->doc_id === 0 && $this->redirect_id === 0;
    }

    public function getIsRedirectAttribute()
    {
        return $this->redirect_id !== 0;
    }

    public function getFullTitleAttribute()
    {
        if (
            $this->relationLoaded('serie') &&
            $this->serie
        ) {
            return $this->serie->name . ' \ ' . $this->title;
        }

        return $this->title;
    }

    public function getUrlAttribute()
    {
        return url(
            '/' . ($this->is_doc ? 'docs' : 'posts') .
            '/' . trim($this->permalink, '/')
        );
    }
}
