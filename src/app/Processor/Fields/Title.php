<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Title
{
    public static function parse(Post $post, Array $file)
    {
        $title      = $file['title'][0];
        $searchable = $post->searchable ?? '';

        $post->meta       = array_merge($post->meta ?? [], ['title' => $title]);
        $post->searchable = str_replace('-', ' ', Str::slug($title . ' ' . $searchable));
        $post->title      = $title;

        return $post;
    }
}