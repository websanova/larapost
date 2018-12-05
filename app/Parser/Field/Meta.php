<?php

namespace Websanova\Larablog\Parser\Field;

class Meta
{
	public static function process($key, $data, $fields)
	{
		if ( ! isset($data['meta'])) {
			$data['meta'] = [];
		}
		else {
			$data['meta'] = (array)json_decode($data['meta']);
		}

        $data['meta'][$key] = $fields[$key];

        $data['meta'] = json_encode($data['meta']);

        return $data;
	}
}