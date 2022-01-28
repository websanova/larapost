<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;
use Websanova\Larablog\Models\Tag;

class Tags
{
    public static function parse(Post $post, Array $file)
    {
        $tags = explode(',', $file['tags'][0]);

        if (!$post->relationLoaded('tags')) {
            $post->setRelation('tags', new Collection);
        }

        foreach ($tags as $tag) {
            $tag = trim($tag);

            if (empty($tag)) {
                continue;
            }

            $post->tags->push(new Tag([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]));
        }

        return $post;
    }
}