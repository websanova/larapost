<?php

namespace Websanova\Larablog\Parsers\Fields;

class Searchable
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        $str = (
            $parse['body'][0] ?? ' ' .
            $parse['description'][0] ?? ' ' .
            $parse['title'][0] ?? ''
        );

        $str = preg_replace('/[^a-zA-Z0-9]+/', ' ', $str);
        $str = strtolower($str);

        $data['posts'][$name]->attributes['searchable'] = $str;

        return $data;
    }
}