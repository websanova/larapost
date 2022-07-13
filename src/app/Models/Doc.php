<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larablog.table.prefix') . 'docs';
    }

    // public function groups()
    // {
    //     return $this->hasMany(config('larablog.models.group'));
    // }

    // public function posts()
    // {
    //     return $this->hasMany(config('larablog.models.post'));
    // }

    public static function build(Array $docs = [])
    {
        self::truncate();

        foreach ($docs as $doc) {
            $doc->model = self::create($doc->attributes);
        }
    }
}
