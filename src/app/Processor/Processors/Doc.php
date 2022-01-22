<?php

namespace Websanova\Larablog\Processor\Processors;

use Websanova\Larablog\Processor\Processor;

class Doc extends Processor
{

    // Step 1: Just parse the files into standard format using a renderer (with body).
    // Step 2: Use the output to start entering data into the database => this is the actual parsers job
    //          - we can use the Parser parent class for commong stuff.

    // Docs dealing with sections?
        // - everything in post somehow?

    public function build()
    {
        // Need hash for checking diffs


        // $files = $this->getFilesInPaths(config('larablog.doc.paths'));

        // foreach ($files as $file) {
        //     // echo $file;
        // }
    }
}