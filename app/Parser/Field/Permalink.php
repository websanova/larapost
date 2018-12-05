<?php

namespace Websanova\Larablog\Parser\Field;

class Permalink
{
	public static function process($key, $data, $fields)
	{
        if (empty($fields['permalink']) && !empty($fields['type_plural'])) {
            
            $prefix = config('larablog.' . $fields['type_plural'] . '.uri');
            $slug = str_slug(@$fields['slug'] ?: @$fields['title'] ?: @$fields['file']);

            $data['permalink'] =
                ( ! empty($prefix) ? '/' . $prefix : '') . 
                '/' . $slug
            ;
        }

		return $data;
	}
}