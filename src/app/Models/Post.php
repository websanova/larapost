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

    public function getTable()
    {
        return config('larablog.table.prefix') . 'posts';
    }

    // public function post()
    // {
    //     return $this->hasOne(Post::class, 'redirect_id');
    // }

    // public function redirects()
    // {
    //     return $this->hasMany(Post::class, 'redirect_id');
    // }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class);
    // }

    public function doc()
    {
        return $this->belongsTo(config('larablog.models.doc'));
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
}
