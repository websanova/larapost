<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public function getTable()
    {
        return config('larablog.table.prefix') . 'tags';
    }
}
