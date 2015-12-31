<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table_tags');
    }

    public function posts()
    {
        return $this->belongsToMany('Websanova\Larablog\Models\Post', 'blog_post_tag');
    }

    public function getUrlAttribute()
    {
        return config('app.url') . config('larablog.tags_path') . '/' . $this->slug;
    }
}
