<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Body
{
    public static function parse(Post $post, Array $file)
    {
        $post->body = $file['body'][0];

        return $post;
    }
}