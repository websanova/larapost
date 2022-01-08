<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;
use Websanova\Larablog\Parsers\DocParser;

class Doc extends Model
{
    public function build()
    {
        (new DocParser)->handle();
    }
}
