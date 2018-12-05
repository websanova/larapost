<?php

namespace Websanova\Larablog\Parser\Field;

class Type
{
	public static function process($key, $data, $fields)
	{
        $data['type'] = $fields['type'];

        return $data;
	}
}