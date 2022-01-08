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

    public function build()
    {
        (new PostParser)->handle();
    }

    public function next()
    {

    }

    public function prev()
    {

    }
}
