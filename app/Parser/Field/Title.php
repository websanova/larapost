<?php

namespace Websanova\Larablog\Parser\Field;

class Title
{
	public static function process($key, $data, $fields)
	{
        if ( ! empty($fields['title'])) {
            $data['title'] = $fields['title'];
        }
        elseif ( ! empty($fields['file'])) {
            $data['title'] = $fields['file'];
        }

        return $data;
	}
}