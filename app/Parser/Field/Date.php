<?php

namespace Websanova\Larablog\Parser\Field;

use Exception;
use Carbon\Carbon;

class Date
{
	public static function process($key, $val, $data)
	{
		try {
			$data['published_at'] = Carbon::createFromFormat('M d Y', $val);
		}
		catch (Exception $e) {
			$data['published_at'] = null;
		}

		return $data;
	}
}