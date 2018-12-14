<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Markdown\Markdown;

class Identifier
{
    public static function process($key, $data, $fields)
    {
        if ( ! empty($fields['identifier'])) {
            $data['identifier'] = $fields['identifier'];
        }
        elseif ( ! empty($fields['file'])) {
            $data['identifier'] = str_slug($fields['file']);
        }

        return $data;
    }
}