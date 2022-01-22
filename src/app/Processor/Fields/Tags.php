<?php

namespace Websanova\Larablog\Processor\Fields;

use Illuminate\Support\Str;

class Tags
{
    public static function parse(Array $data, Array $file)
    {
        $tags = explode(',', $file['tags'][0]);

        foreach ($tags as $tag) {
            $tag = trim($tag);

            if (empty($tag)) {
                continue;
            }

            $data['relations']['tags'][]= [
                'name' => $tag,
                'slug' => Str::slug($tag),
            ];
        }

        return $data;
    }
}