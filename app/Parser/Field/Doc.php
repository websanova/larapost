<?php

namespace Websanova\Larablog\Parser\Field;

class Doc extends Series
{
    public static function process($key, $val, $data, $type = 'docs')
    {
        return parent::process($key, $val, $data, $type);
    }

    public function cleanup($type = 'docs')
    {
        return parent::cleanup($type);
    }
}