<?php

namespace Websanova\Larablog\Processor\Fields;

use Websanova\Larablog\Models\Post;

class Image
{
    public static function parse(Post $post, Array $file)
    {
        $post->meta = array_merge($post->meta ?? [], ['image' => $file['image'][0]]);

        return $post;
    }
}