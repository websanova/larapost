<?php

namespace Websanova\Larapost\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public $timestamps = false;

    public function getTable()
    {
        return config('larapost.table.prefix') . 'docs';
    }

    public function posts()
    {
        return $this->hasMany(config('larapost.models.post'));
    }

    public static function build(Array $docs = [])
    {
        self::truncate();

        foreach ($docs as $doc) {
            $doc->model = self::create($doc->attributes);
        }
    }

    public function getMenuAttribute()
    {
        $data  = [];
        $group = null;

        foreach ($this->posts as $post) {
            if ($post->group) {
                if ($post->group->id !== ($group->id ?? null)) {
                    $group = $post->group;

                    $data[]= [
                        'group' => $post->group,
                        'posts' => []
                    ];
                }

                $data[count($data) - 1]['posts'][]= $post;
            }
            else {
                $data[]= [
                    'post' => $post,
                ];
            }
        }

        return collect($data);
    }

    public function getUrlAttribute()
    {
        return url('/docs/' . $this->slug);
    }
}
