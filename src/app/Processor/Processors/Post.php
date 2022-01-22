<?php

namespace Websanova\Larablog\Processor\Processors;

use Websanova\Larablog\Processor\Processor;

class Post extends Processor
{
    public function build()
    {
        // 1. need to set existing
        // 2. parse fetch all files raw
        // 3. Tricky part is comparing for any changes.
        //      - keep it simple with md5($contents) => this contents should exclude space/tab formatting.
        //

        parent::build();

        print_r($this->output);

        // $files = $this->getFilesInPaths(config('larablog.post.paths'));

        // foreach ($files as $file) {
        //     print_r($this->parse($file));
        // }
    }
}