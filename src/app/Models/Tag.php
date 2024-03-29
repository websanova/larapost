<?php

namespace Websanova\Larapost\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larapost.table.prefix') . 'tags';
    }

    public function posts()
    {
        return $this->belongsToMany(config('larapost.models.post'));
    }

    public static function build(Array $tags = [])
    {
        self::truncate();

        foreach ($tags as $tag) {
            $tag->model = self::create($tag->attributes);
        }
    }

    public function getUrlAttribute()
    {
        return url('/tags/' . $this->slug);
    }
}
