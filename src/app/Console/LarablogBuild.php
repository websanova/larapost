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
        $this->info('> Larablog: Build');

        $lb = Larablog::processor();

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
        $errors = $lb->getParseErrors();

        foreach ($errors as $key => $file) {
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
        $this->echoInput('create', $lb->getModelsCreate());
    }

    public function echoDelete($lb)
    {
        $this->echoInput('delete', $lb->getModelsDelete());
    }

    public function echoUpdate($lb)
    {
        $this->echoInput('update', $lb->getModelsUpdate());
    }

    public function echoInput(String $op, Array $models_by_class)
    {
        foreach ($models_by_class as $class => $models) {
            $this->comment('  > ' . ucfirst($op) . ': ' . $class);

            foreach ($models as $model) {
                $this->line(
                    '    > ' . $model->type . ' : ' . $model->{config('larablog.keys')[$model::class]}
                );

                foreach ($model->getDirty() as $attr => $val) {
                    $orig = $model->getOriginal($attr) ?? null;
                    $orig = is_array($orig) ? json_encode($orig) : $orig;

                    $this->line('<fg=green>' . substr('      + ' . $attr . ' : ' . $val, 0, 100) . '</>');

                    if ($orig) {
                        $this->line('<fg=red>' . substr('      - ' . $attr . ' : ' . $orig, 0, 100) . '</>');
                    }
                }

                foreach ($model->getRelations() as $relation_key => $relation_models) {
                    $attr_key = config('larablog.keys')[$model->{$relation_key}()->getRelated()::class];

                    if ($model->isDirtyRelation($relation_key, $attr_key)) {
                        foreach ($model->getDirtyRelationCreate($relation_key, $attr_key) as $model_new) {
                            $this->line('<fg=green>' . substr('      + ' . $relation_key . ' : ' . $model_new->{$attr_key}, 0, 100) . '</>');
                        }

                        foreach ($model->getDirtyRelationDelete($relation_key, $attr_key) as $model_new) {
                            $this->line('<fg=red>' . substr('      - ' . $relation_key . ' : ' . $model_new->{$attr_key}, 0, 100) . '</>');
                        }
                    }
                }
            }

            $this->line('');
        }
    }
}