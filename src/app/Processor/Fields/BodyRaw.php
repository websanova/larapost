<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class BodyRaw
{
    public static function parse(Post $post, Array $file)
    {
        $body       = $file['body-raw'][0];
        $searchable = $post->searchable ?? '';

        $post->searchable = str_replace('-', ' ', Str::slug($body . ' ' . $searchable));

        return $post;
    }
}