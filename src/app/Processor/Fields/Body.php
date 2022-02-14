<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Body
{
    public static function parse(Post $post, Array $file)
    {
        $post->body = Str::markdown($file['body'][0]);
        $searchable = $post->searchable ?? '';

        $post->searchable = str_replace('-', ' ', Str::slug($file['body'][0] . ' ' . $searchable));

        return $post;
    }
}