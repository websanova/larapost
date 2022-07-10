<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larablog.table.prefix') . 'tags';
    }

    public static function build(Array $tags = [])
    {
        self::truncate();

        foreach ($tags as $tag) {
            $tag->model = self::create($tag->attributes);
        }
    }

    public function getPermalinkAttribute()
    {
        return '/' . $this->slug;
    }
}
