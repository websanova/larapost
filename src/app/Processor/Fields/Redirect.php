<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Collection;
use Websanova\Larablog\Models\Post;

class Redirect
{
    public static function parse(Post $post, Array $file)
    {
        if (!$post->relationLoaded('redirects')) {
            $post->setRelation('redirects', new Collection);
        }

        foreach($file['redirect'] as $redirect) {
            $post->redirects->push(new Post([
                'permalink' => '/' . trim($redirect, '/'),
                'body'      => '/' . trim($file['permalink'][0], '/'),
                'type'      => 'redirect',
            ]));
        }

        return $post;
    }
}