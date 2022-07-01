<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;
use Websanova\Larablog\Parsers\PostParser;

class Post extends Model
{
    // use Concerns\ManagesDirtyRelations;

    protected $casts = [
        'meta' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $guarded = [];

    protected $hidden = [];

    // For post to doc, redirect to post
    public function postable()
    {
        return $this->morphTo();
    }

    // public function doc()
    // {
    //     return $this->belongsTo(Doc::class);
    // }

    // public function redirects()
    // {
    //     // TODO: Use morph here for id instead of this...

    //     return $this->morphMany(Post::class, 'postable');

    //     // return $this->hasMany(Post::class, 'body', 'permalink');
    // }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
