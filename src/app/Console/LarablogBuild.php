<?php

namespace Websanova\Larablog\Console;

use Illuminate\Console\Command;
use Websanova\Larablog\Larablog;

// use Websanova\Larablog\Parser\Type\Doc;
// use Websanova\Larablog\Parser\Type\Page;
// use Websanova\Larablog\Parser\Type\Post;

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
    protected $description = 'Update docs and posts.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $this->info('> Larablog: posts');

        $lb = Larablog::post();

        // Parse

        $lb->parse();

        $this->echoError($lb);

        // Process

        $lb->process();

        $this->echoCreate($lb);

        $this->echoUpdate($lb);

        $this->echoDelete($lb);

        // Save
        $lb->save();

        // $lb->inserts()->each();

        // $lb->updates()->each();

        // $lb->deletes()->each();





        // $this->info('Larablog: docs');

        // Larablog::doc()->build();

        // Larablog::post()->build();

        // Larablog::post()->paginate();

        // $doc = Larablog::doc();

        // // $doc->parse();
        // $parser = $doc->build();

        // $parser->errors();

        // $doc->paginate();
        // $doc->find(0);


        // (new Larablog)->post()->build();



        // (new Post)->handle();

        // (new Page)->handle();

        // (new Doc)->handle();
    }

    public function echoError($lb)
    {
        $output = $lb->getOutput();

        foreach ($output['error'] as $key => $file) {
            $this->comment('  > Error: ' . $key);

            $this->line(
                '    - ' .
                str_pad($file['error']['code'], 9) . ': ' .
                $file['error']['msg']
            );

            $this->line('');
        }
    }

    public function echoCreate($lb)
    {
        $this->echoInput($lb, 'create');
    }

    public function echoDelete($lb)
    {
        $this->echoInput($lb, 'delete');
    }

    public function echoUpdate($lb)
    {
        $this->echoInput($lb, 'update');
    }

    public function echoInput($lb, $op)
    {
        $output = $lb->getOutput();

        $classes = $output[$op];

        foreach ($classes as $class => $models) {
            $this->comment('  > ' . ucfirst($op) . ': ' . $class);

            foreach ($models as $model) {
                $this->line(
                    '    > ' . $model->type . ' : ' . $model->{$model->getUniqueKey()}
                );

                // TODO: If model or relation is dirty.

                foreach ($model->getDirty() as $key => $val) {
                    $orig = $model->getOriginal($key);

                    if ($orig && is_array($orig)) {
                        $orig = json_encode($orig);
                    }

                    $this->line('<fg=green>' . substr('      + ' . $key . ' : ' . $val, 0, 100) . '</>');

                    if ($orig) {
                        $this->line('<fg=red>' . substr('      - ' . $key . ' : ' . $orig, 0, 100) . '</>');
                    }

                    foreach ($model->getRelations() as $relation => $relation_models) {

                        // if ($model->relationLoaded($relation)) {
                        //     print_r($model->{$relation}->toArray());
                        // }

                        // if ($model->relationLoaded($relation . '_new')) {
                        //     print_r($model->{$relation . '_new'}->toArray());
                        // }
                    }
                }
            }

            $this->line('');
        }
    }
}