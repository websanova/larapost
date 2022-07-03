<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larablog.table.prefix') . 'groups';
    }

    public function doc()
    {
        return $this->belongsTo(config('larablog.models.doc'));
    }

    public function posts()
    {
        return $this->hasMany(config('larablog.models.post'));
    }
}
