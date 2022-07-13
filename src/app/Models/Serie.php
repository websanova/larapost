<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larablog.table.prefix') . 'series';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function build(Array $series = [])
    {
        self::truncate();

        foreach ($series as $serie) {
            $serie->model = self::create($serie->attributes);
        }
    }

    public function getUrlAttribute()
    {
        return url('/series/' . $this->slug);
    }
}
