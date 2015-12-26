<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Markdown\Markdown;

class Body
{
	public static function process($key, $val, $data)
	{
        $data['body'] = Markdown::extra($val);

        return $data;
	}
}