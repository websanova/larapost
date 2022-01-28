<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;
use Websanova\Larablog\Models\Tag;

class Tags
{
    public static function parse(Array $record, Array $file)
    {
        $tags = explode(',', $file['tags'][0]);

        foreach ($tags as $tag) {
            $tag = trim($tag);

            if (empty($tag)) {
                continue;
            }

            $data = [
                'name' => $tag,
                'slug' => Str::slug($tag),
            ];

            $tag = Tag::where('slug', $data['slug'])->first();

            if (!$tag) {
                $tag = Tag::create($data);
            }

            $record['relations']['tags'][]= $tag;
        }

        return $record;
    }
}