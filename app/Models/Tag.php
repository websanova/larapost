<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table.prefix') . '_tags';
    }

    public function posts()
    {
        return $this->belongsToMany('Websanova\Larablog\Models\Post', config('larablog.table.prefix') . '_post_tag');
    }

    public function getUrlAttribute()
    {
        return route('tags') . '/' . $this->slug;
    }
}
