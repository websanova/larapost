<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public function getTable()
    {
        return config('larablog.table.prefix') . 'docs';
    }


    public function groups()
    {
        return $this->hasMany(config('larablog.models.group'));
    }

    public function posts()
    {
        return $this->hasMany(config('larablog.models.post'));
    }
}
