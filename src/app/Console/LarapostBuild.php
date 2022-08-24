<?php

namespace Websanova\Larapost\Console;

use Illuminate\Console\Command;
use Websanova\Larapost\Larapost;

class LarapostBuild extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'larapost:build';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Build larapost docs and posts.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $this->info(' > Larapost: Build start');

        $out = Larapost::build();

        if ($out['status'] === 'error') {
            $this->error(' > Larapost: Build error');

            foreach ($out['data']['errors'] as $error) {
                $this->error('   - ' . $error['name'] . ': ' . $error['msg']);
            }

            return;
        }

        $this->info(' > Larapost: Build complete');

        foreach (config('larapost.models') as $key => $model) {
            $this->comment('   - ' . count($out['data'][$key] ?? []) . ' ' . $key);
        }
    }
}