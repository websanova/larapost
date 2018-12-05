<?php

namespace Websanova\Larablog\Parser\Field;

class Doc extends Series
{
    public static function process($key, $data, $fields)
    {
        return parent::process($key, $data, $fields);
    }

    public function cleanup($key = 'docs')
    {
        return parent::cleanup($key);
    }
}