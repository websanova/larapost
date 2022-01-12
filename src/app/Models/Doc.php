<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;
use Websanova\Larablog\Parsers\DocParser;

class Doc extends Model
{
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    // public function build()
    // {
    //     $parser = new DocParser;

    //     $parser->handle();

    //     return $parser;
    // }
}
