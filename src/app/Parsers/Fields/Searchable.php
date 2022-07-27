<?php

namespace Websanova\Larablog\Parsers\Fields;

class Searchable
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        $str = (
            ($parse['body'][0] ?? null) . ' ' .
            ($parse['description'][0] ?? null) . ' ' .
            ($parse['title'][0] ?? null)
        );

        $str = preg_replace('/[^a-zA-Z0-9]+/', ' ', $str);
        $str = strtolower($str);
        $str = trim($str);

        $data['post'][$name]->attributes['searchable'] = $str;

        return $data;
    }
}