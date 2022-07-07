<?php

namespace Websanova\Larablog\Console;

use Illuminate\Console\Command;
use Websanova\Larablog\Larablog;

class LarablogBuild extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'larablog:build';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Build larablog docs and posts.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $this->info(' > Larablog: Build start');

        $out = Larablog::build();

        if ($out['status'] === 'error') {
            $this->error(' > Larablog: Build error');

            foreach ($out['data']['errors'] as $error) {
                $this->error('   - ' . $error['name'] . ': ' . $error['msg']);
            }

            return;
        }

        $this->info(' > Larablog: Build complete');

        foreach (config('larablog.models') as $key => $model) {
            $this->comment('   - ' . count($out['data'][$key] ?? []) . ' ' . $key);
        }
    }
}