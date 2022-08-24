<?php

namespace Websanova\Larapost\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larapost.table.prefix') . 'groups';
    }

    public function doc()
    {
        return $this->belongsTo(config('larapost.models.doc'));
    }

    public function posts()
    {
        return $this->hasMany(config('larapost.models.post'));
    }

    public static function build(Array $groups = [])
    {
        self::truncate();

        foreach ($groups as $group) {
            $group->attributes['doc_id'] = $group->relations['doc']->model->id;

            $group->model = self::create($group->attributes);
        }
    }
}
