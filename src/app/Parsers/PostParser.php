<?php

namespace Websanova\Larablog\Parsers;

class PostParser extends Parser
{
    public function handle()
    {
        $files = $this->getFilesInPaths(config('larablog.post.paths'));

        print_r($files);
    }
}