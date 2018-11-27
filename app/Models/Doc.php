<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table.prefix') . 'docs';
    }

    public function sections()
    {
        return $this->hasMany('Websanova\Larablog\Models\Section');
    }

    public function getUrlAttribute()
    {
        return route('docs') . '/' . $this->slug;
    }
}