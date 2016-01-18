<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table.prefix') . '_series';
    }

    public function posts()
    {
        return $this->hasMany('Websanova\Larablog\Models\Post');
    }

    public function getUrlAttribute()
    {
        return route('series') . '/' . $this->slug;
    }
}
