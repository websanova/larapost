<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Permalink
{
    public static function parse(Post $post, Array $file)
    {
        $post->permalink = '/' . trim($file['permalink'][0], '/');

        return $post;
    }
}