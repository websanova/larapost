<?php

namespace Websanova\Larablog\Processor;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Processor
{
    //

    private $error   = [];
    private $success = [];

    //

    private $create = [];
    private $delete = [];
    private $update = [];

    //




    /*
     * Track all the relations associated with a model.
     */
    // private $model_relations = [];


    //

    // /*
    //  * Capture all the relations for each model.
    //  */
    // private $relations = [
    //     //
    // ];

    // /*
    //  * Capture all the classes of each relation.
    //  */
    // private $classes = [
    //     //
    // ];

    /*
     * Default parser.
     */
    // private $parser = \Websanova\Larablog\Processor\Parsers\LarablogMarkdown::class;

    // /*
    //  * @return Void
    //  */
    // public function __construct()
    // {
    //     if (!$this->name) {
    //         $this->name = $this->getName();
    //     }
    // }

    /*
     * Process all files in all paths.
     *
     * @return Void
     */
    public function parse()
    {
        $paths = $this->getPaths();
        $files = $this->getFiles($paths);

        foreach ($files as $file) {
            $parse  = $this->getParsed($file);
            $result = isset($parse['error']) ? 'error' : 'success';

            $this->{$result}[$file] = $parse;
        }

        return $this;
    }

    public function process()
    {
        $models_by_class = [];
        $model_relations = [];

        if ($this->isParseErrors()) {
            return;
        }

        // Gather up all the models (direct and relations).
        foreach ($this->getParseSuccess() as $file) {
            $post = $this->initPost($file);

            $models_by_class[$post::class][]= $post;

            // Dynamically keep track of post relations since
            // we don't know what will come out of the fields.
            $model_relations[$post::class] = array_unique(array_merge(
                $model_relations[$post::class] ?? [],
                array_keys($post->getRelations())
            ));

            foreach ($post->getRelations() as $relation_key => $relation_models) {
                foreach ($relation_models as $relation_model) {
                    $models_by_class[$relation_model::class][]= $relation_model;
                }
            }
        }

        // Compare create/delete/update.
        foreach ($models_by_class as $model_class => $models) {
            $attr_key = $this->getAttributeKey($model_class);

            $db  = $model_class::with($model_relations[$model_class] ?? [])->get();
            $raw = (new Collection($models))->unique($attr_key);

            $this->create[$model_class] = $raw->whereNotIn($attr_key, $db->pluck($attr_key)->toArray());
            $this->delete[$model_class] = $db->whereNotIn($attr_key, $raw->pluck($attr_key)->toArray());
            $this->update[$model_class] = collect();

            // Updates require a bit of finessing for dirty checks.
            $db     = $db->keyBy($attr_key);
            $update = $raw->whereIn($attr_key, $db->pluck($attr_key)->toArray());

            foreach ($update as $model_raw) {
                $model_db = $db[$model_raw->{$attr_key}];

                // Generic fill which will work nicely for create/update
                // and any isDirty checks for diff print out later on.
                $model_db->fill($model_raw->withoutRelations()->toArray());

                foreach ($model_db->getRelations() as $relation_key => $relation_models) {
                    $model_db->fillRelation($relation_key, $model_raw->{$relation_key} ?? null);
                }

                // Check for any changes on the model.
                if ($this->isModelDirty($model_db)) {
                    $this->update[$model_class]->push($model_db);
                }
            }
        }

        return $this;
    }

    public function save()
    {





        // // $classes = $this->getClasses();
        // // $files   = $this->getOutput();

        // if ($this->isParseErrors()) {
        //     return;
        // }

        // $output = [];

        // // Merge create/update data since they can run the same
        // // save operations for model save and relation sync.
        // foreach (['create', 'update'] as $op) {
        //     foreach ($this->output[$op] as $class => $models) {
        //         if (!isset($output[$class])) {
        //             $output[$class] = new Collection;
        //         }

        //         $output[$class] = $output[$class]->merge($models);
        //     }
        // }

        // // Save create/update models.
        // foreach ($output as $class => $models) {
        //     foreach ($models as $model) {
        //         $model->save();
        //     }
        // }

        // // Reload all the db data, at this point there
        // // should be no new data that is NOT in the db.
        // $db = [];

        // foreach ($this->relations as $class => $relations) {
        //     $key = (new $class)->getUniqueKey();

        //     $db[$class] = $class::with($relations)->get()->keyBy($key);
        // }

        // // Update create/update relations.
        // foreach ($output as $class => $models) {
        //     foreach ($models as $model) {
        //         foreach ($model->getRelations() as $relation => $relation_models) {
        //             $relation_class = $classes[$relation] ?? null;

        //             if (!$relation_class) {
        //                 continue;
        //             }

        //             $relation_key = (new $relation_class)->getUniqueKey();

        //             // $sync_models = new Collection;

        //             // echo $relation;
        //             // echo 'hi';

        //             if (method_exists($model->{$relation}(), 'sync')) {
        //                 $ids = [];

        //                 foreach ($relation_models as $relation_model) {
        //                     $ids[]= $db[$relation_class][$relation_model->{$relation_key}]->id;
        //                 }

        //                 $model->{$relation}()->sync($ids);
        //             }

        //             else {
        //                 foreach ($relation_models as $relation_model) {
        //                     $model_db = $db[$relation_class][$relation_model->{$relation_key}];

        //                     if (
        //                         !$model->{'_' . $relation} ||
        //                         !$model->{'_' . $relation}->contains($model_db)
        //                     ) {
        //                         $model->{$relation}()->save($model_db);
        //                     }
        //                 }
        //             }




        //             // print_r($sync_ids);


        //             // $new_keys = $model->{'_' . $relation} ? $model->{'_' . $relation}



        //             // $model->{$relation}()->delete();
        //             // $model->{$relation}()->saveMany($sync_models);

        //             // TODO: Just need to run sync here on the relation with new.
        //         }
        //     }
        // }

        // // Wipe out deletes and associated relations.
        // foreach ($this->output['delete'] as $class => $models) {
        //     foreach ($models as $model) {
        //         $key      = $model->getUniqueKey();
        //         $model_db = $db[$model::class][$model->{$key}];

        //         foreach ($model_db->getRelations() as $relation => $relation_models) {
        //             $model_db->{$relation}()->delete();
        //         }

        //         $model_db->delete();
        //     }
        // }
    }








    /*
     * Get error formatted.
     *
     * @return Array
     */
    public function getError(String $code, String $msg)
    {
        return [
            'error' => [
                'code' => $code,
                'msg'  => $msg,
            ]
        ];
    }

    /*
     * Loop through all paths to collect all files.
     *
     * @param  Array $paths
     * @return Array
     */
    public function getFiles(Array $paths = [])
    {
        $files = [];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $files = array_merge($files, $this->getFilesInDir($path));
            }
        }

        return $files;
    }

    /*
     * Get all the files in a directory recursively.
     *
     * @param  String $dir
     * @return Array
     */
    public function getFilesInDir(String $dir = null)
    {
        $files = [];

        if (is_dir($dir)) {
            $paths = scandir($dir);

            foreach ($paths as $path) {
                if ($path === '.' || $path === '..') {
                    continue;
                }

                $path = $dir . '/' . $path;

                if (is_file($path)) {
                    $files[]= $path;
                }
                elseif (is_dir($path)) {
                    $files = array_merge($files, $this->getFilesInDir($path));
                }
            }
        }

        return $files;
    }

    public function getAttributeKey(String $model_class)
    {
        return config('larablog.keys.' . $model_class);
    }

    public function getFieldClass(String $key)
    {
        return config('larablog.fields.' . $key);
    }

    public function getModelsCreate()
    {
        return $this->create;
    }

    public function getModelsDelete()
    {
        return $this->delete;
    }

    public function getModelsUpdate()
    {
        return $this->update;
    }

    public function getPaths()
    {
        return config('larablog.paths');
    }

    public function getParseErrors()
    {
        return $this->error;
    }

    public function getParseSuccess()
    {
        return $this->success;
    }

    public function getParser()
    {
        return config('larablog.parser');
    }

    public function getParsed(String $file = null)
    {
        if (is_file($file)) {
            $contents = file_get_contents($file);

            try {
                $parser = $this->getParser();

                return $parser::parse($contents);
            }
            catch(Exception $e) {
                return $this->getError('invalid', 'Format: ' . $e->getMessage());
            }
        }
        else {
            return $this->getError('fdne', 'File does not exist');
        }
    }

    public function getPostClass()
    {
        return config('larablog.post');
    }

    public function initPost(Array $file = null)
    {
        $class = $this->getPostClass();
        $post  = new $class;

        foreach ($file as $key => $val) {
            $class = $this->getFieldClass($key);
            $post  = $class::parse($post, $file);
        }

        return $post;
    }

    public function isModelDirty($model_db)
    {
        if ($model_db->isDirty()) {
            return true;
        }

        foreach ($model_db->getRelations() as $relation_key => $relation_models) {
            $attr_key = $this->getAttributeKey($model_db->{$relation_key}()->getRelated()::class);

            if ($model_db->isDirtyRelation($relation_key, $attr_key)) {
                return true;
            }
        }

        return false;
    }

    public function isParseErrors()
    {
        return count($this->getParseErrors()) ? true : false;
    }
}