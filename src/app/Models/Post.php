<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;
use Websanova\Larablog\Parsers\PostParser;

class Post extends Model
{
    public function postable()
    {
        return $this->morphTo();
    }

    // public function build()
    // {
    //     $parser = new PostParser;

    //     $parser->handle();

    //     return $parser;
    // }

    public function next()
    {

    }

    public function prev()
    {

    }
}
