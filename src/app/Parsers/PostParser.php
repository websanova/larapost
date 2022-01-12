<?php

namespace Websanova\Larablog\Parsers;

class PostParser extends Parser
{
    public function build()
    {
        // 1. need to set existing
        // 2. parse fetch all files raw
        // 3. Tricky part is comparing for any changes.
        //      - keep it simple with md5($contents) => this contents should exclude space/tab formatting.
        //

        $output = $this->handle(config('larablog.post.paths'));

        print_r($output);

        // $files = $this->getFilesInPaths(config('larablog.post.paths'));

        // foreach ($files as $file) {
        //     print_r($this->parse($file));
        // }
    }
}