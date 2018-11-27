<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table.prefix') . 'sections';
    }

    public function getUrlAttribute()
    {
        return route('docs') . '/' . $this->slug;
    }
}