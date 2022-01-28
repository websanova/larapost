<?php

namespace Websanova\Larablog\Processor\Fields;

use Websanova\Larablog\Models\Post;

class Keywords
{
    public static function parse(Post $post, Array $file)
    {
        $post->meta = array_merge($post->meta ?? [], ['keywords' => $file['keywords'][0]]);

        return $post;
    }
}