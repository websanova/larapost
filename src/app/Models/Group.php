<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public function getTable()
    {
        return config('larablog.table.prefix') . 'groups';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
