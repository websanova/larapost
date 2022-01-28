<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;
use Websanova\Larablog\Parsers\PostParser;

class Post extends Model
{
    protected $casts = [
        'meta' => 'object',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $guarded = [];

    protected $hidden = [];

    // public function postable()
    // {
    //     return $this->morphTo();
    // }

    public function redirects()
    {
        return $this->hasMany(Post::class, 'body', 'permalink');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }



    public function next()
    {
        // order by date, name
    }

    public function prev()
    {
        // order by date, name

    }
}
