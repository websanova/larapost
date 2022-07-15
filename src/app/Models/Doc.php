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

    public function posts()
    {
        return $this->hasMany(config('larablog.models.post'));
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

        if ($this->relationLoaded('posts')) {
            foreach ($this->posts as $post) {
                if ($post->group) {
                    if ($post->group->id !== ($group->id ?? null)) {
                        $group = $post->group;

                        $data[]= [
                            'title' => $post->group->name,
                            'posts' => []
                        ];
                    }

                    $data[count($data) - 1]['posts'][]= [
                        'title' => $post->title,
                    ];
                }
                else {
                    $data[]= [
                        'title' => $post->title,
                    ];
                }
            }

            return collect($data);
        }

        return null;
    }

    public function getUrlAttribute()
    {
        return url('/docs/' . $this->slug);
    }
}
