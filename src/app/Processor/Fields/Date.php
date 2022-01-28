<?php

namespace Websanova\Larablog\Processor\Fields;

use Carbon\Carbon;
use Websanova\Larablog\Models\Post;

class Date
{
    public static function parse(Post $post, Array $file)
    {
        $post->published_at = Carbon::parse($file['date'][0]);

        return $post;
    }
}