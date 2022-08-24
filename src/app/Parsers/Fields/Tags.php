<?php

namespace Websanova\Larapost\Parsers\Fields;

use Exception;
use Illuminate\Support\Str;

class Tags
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['tags'])) {
            return $data;
        }

        $tags = explode(',', $parse['tags'][0]);

        foreach ($tags as $tag) {
            $tag = trim($tag);

            if (empty($tag)) {
                throw new Exception('Tag is empty.');
            }

            if (!isset($data['tag'][$tag])) {
                $data['tag'][$tag] = (object)[
                    'attributes' => [
                        'name' => $tag,
                        'slug' => Str::slug($tag),
                    ]
                ];
            }

            $data['post'][$name]->relations['tags'][]= $data['tag'][$tag];
        }

        return $data;
    }
}