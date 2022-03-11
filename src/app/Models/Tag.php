<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    // public function getTypeAttribute($val)
    // {
    //     return $val ?? 'tag';
    // }

    public function getUniqueKey()
    {
        return 'slug';
    }
}
