<?php

namespace Websanova\Larablog\Parsers\Fields;

use Exception;

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

            if (!isset($data['tags'][$tag])) {
                $data['tags'][$tag] = [
                    'name' => $tag
                ];
            }

            $data['posts'][$name]->tags[]= $data['tags'][$tag];
        }

        return $data;
    }
}