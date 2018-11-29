<?php

namespace Websanova\Larablog\Parser\Type;

use Websanova\Larablog\Parser\Type;
use Websanova\Larablog\Parser\Field\Tags;
use Websanova\Larablog\Parser\Field\Series;

class Post extends Type
{
    public function cleanup()
    {
        (new Tags)->cleanup();
        
        (new Series)->cleanup();
    }
}