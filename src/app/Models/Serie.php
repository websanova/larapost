<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
