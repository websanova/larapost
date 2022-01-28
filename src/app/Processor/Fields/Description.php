<?php

namespace Websanova\Larablog\Processor\Fields;

use Websanova\Larablog\Models\Post;

class Description
{
    public static function parse(Post $post, Array $file)
    {
        $post->meta = array_merge($post->meta ?? [], ['description' => $file['description'][0]]);

        return $post;
    }
}