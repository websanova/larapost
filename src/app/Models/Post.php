<?php

namespace Websanova\Larablog\Models;

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
        return config('larablog.table.prefix') . 'posts';
    }

    public function doc()
    {
        return $this->belongsTo(config('larablog.models.doc'));
    }

    public function group()
    {
        return $this->belongsTo(config('larablog.models.group'));
    }

    public function redirect()
    {
        return $this->belongsTo(config('larablog.models.post'), 'redirect_id');
    }

    public function redirects()
    {
        return $this->hasMany(config('larablog.models.post'), 'redirect_id');
    }

    public function serie()
    {
        return $this->belongsTo(config('larablog.models.serie'));
    }

    public function tags()
    {
        return $this->belongsToMany(config('larablog.models.tag'));
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

    public static function loadPosts()
    {
        return self::query()
            ->isPost()
            ->orderBy('published_at', 'desc')
            ->paginate();
    }

    public function nextPageUrl()
    {
        return '';
    }

    public function previousPageUrl()
    {
        return '';
    }

    public function scopeIsDoc($q)
    {
        $q->where('doc_id', '<>', 0);
    }

    public function scopeIsPost($q)
    {
        $q->where('doc_id', 0);
        $q->where('redirect_id', 0);
    }

    public function scopeIsPostOrRedirect($q)
    {
        $q->where('doc_id', 0);
    }

    public function getIsDocAttribute($q)
    {
        return $this->doc_id !== 0;
    }

    public function getIsRedirectAttribute($q)
    {
        return $this->redirect_id !== 0;
    }

    public function getUrlAttribute()
    {
        return (
            '/' . ($this->is_doc ? 'docs' : 'blog') .
            '/' . trim($this->permalink, '/')
        );
    }
}
