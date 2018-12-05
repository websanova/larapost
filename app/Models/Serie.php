<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.tables.prefix') . 'series';
    }

    public function posts()
    {
        return $this->hasMany('Websanova\Larablog\Models\Post');
    }

    public function getUrlAttribute()
    {
        return route($this->type) . '/' . $this->slug;
    }

    public function getChaptersAttribute()
    {

        if ($this->relationLoaded('posts')) {
            foreach ($this->posts as $post) {
                preg_match_all('/\<h2\>(.*)\<\/h2\>/msU', $post->body, $matches);
        
                if (isset($matches[1]) && is_array($matches[1])) {
                    $sections = [];

                    foreach ($matches[1] as $match) {
                        $sections[]= (object)[
                            'title' => $match,
                            'slug' => str_slug($match)
                        ];
                    }

                    $post->sections = new \Illuminate\Database\Eloquent\Collection($sections);
                }
            }

            return $this->posts;
        }
    }
}
