<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Markdown\Markdown;

class Body
{
	public static function process($key, $val, $data)
	{
        $data['body'] = Markdown::extra($val);

        preg_match_all('/\<h2\>(.*)\<\/h2\>/', $data['body'], $matches, PREG_OFFSET_CAPTURE);
        
        if (isset($matches[0]) && is_array($matches[0])) {
            $matches[0] = array_reverse($matches[0]);
            $matches[1] = array_reverse($matches[1]);

            foreach ($matches[0] as $index => $match) {
                $data['body'] = substr_replace($data['body'], '<a name="' . str_slug($matches[1][$index][0]) . '" class="anchor"></a>', $match[1], 0);
            }
        }

        $data['body'] = str_replace("\n", '', $data['body']);
        
        return $data;
	}
}