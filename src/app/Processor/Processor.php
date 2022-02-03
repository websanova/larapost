<?php

namespace Websanova\Larablog\Processor;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Processor
{
    /*
     * Current procssor name used to reference config options.
     */
    private $name = null;

    /*
     * Output of build parsing as error/success.
     */
    private $output = [
        'error'   => [],
        'success' => [],

        //

        'create' => [],
        'delete' => [],
        'update' => [],
    ];

    /*
     * Capture all the relations for each model.
     */
    private $relations = [
        //
    ];

    /*
     * Capture all the classes of each relation.
     */
    private $classes = [
        //
    ];

    /*
     * Default parser.
     */
    private $parser = \Websanova\Larablog\Processor\Parsers\LarablogMarkdown::class;

    /*
     * @return Void
     */
    public function __construct()
    {
        if (!$this->name) {
            $this->name = $this->getName();
        }
    }

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

            $this->output[$result][$file] = $parse;
        }

        return $this;
    }

    public function process()
    {
        $output  = [];
        $files = $this->getOutput();

        if (count($files['error'])) {
            return;
        }

        foreach ($files['success'] as $file) {
            $post = new Post;

            // Collect all the field data.
            foreach ($file as $key => $val) {
                $class = '\\Websanova\\Larablog\\Processor\\Fields\\' . ucfirst(Str::camel($key));

                $post = $class::parse($post, $file);
            }

            // Collect all raw post data.
            $output[$post::class][]= $post;

            foreach ($post->getRelations() as $relation => $relation_models) {

                // Gather all classes and relations used on all the raw
                // models. Unfortunately, not much better way to do this
                // dynamically as it needs to come from the raw data set.
                $this->relations[$post::class] = array_unique(array_merge($this->relations[$post::class] ?? [], array_keys($post->getRelations())));

                foreach ($relation_models as $relation_model) {

                    // We also need to collect the relations classes
                    // which we'll need later on to dynamically get
                    // the unique keys need for running diffs.
                    $this->classes[$relation] = $relation_model::class;

                    $output[$relation_model::class][]= $relation_model;

                    // Gather from above on relation models.
                    if ($post::class !== $relation_model::class) {
                        $this->relations[$relation_model::class] = [];
                    }
                }
            }
        }

        // Compare create/delete/update.
        foreach ($output as $class => $models) {
            $db  = $class::with($this->relations[$class])->get();
            $key = (new $class)->getUniqueKey();
            $raw = new Collection($models);
            $raw = $raw->unique($key);

            $this->output['create'][$class] = $raw->whereNotIn($key, $db->pluck($key)->toArray());
            $this->output['delete'][$class] = $db->whereNotIn($key, $raw->pluck($key)->toArray());
            $this->output['update'][$class] = [];

            // Updates require a bit of finessing for dirty checks.
            $db     = $db->keyBy($key);
            $update = $raw->whereIn($key, $db->pluck($key)->toArray());

            foreach ($update as $model) {

                // Generic fill which will work nicely for create/update
                // and any isDirty checks for diff print out later on.
                $db[$model->{$key}]->fill($model->withoutRelations()->toArray());

                // Check for dirty relations which will be done manually
                // here by comparing the raw set to the db relation set.
                $is_dirty_relation = false;

                foreach ($model->getRelations() as $relation => $relation_models) {

                    // This is a temp var which will be useful for printing out
                    // diffs later on and for running a sync on any create/update.
                    $db[$model->{$key}]->setRelation($relation . '_new', $relation_models);

                    $relation_key         = (new $this->classes[$relation])->getUniqueKey();
                    $relation_db_keys     = $db[$model->{$key}]->{$relation}->pluck($relation_key)->toArray();
                    $relation_models_keys = $relation_models->pluck($relation_key)->toArray();

                    if (
                        array_diff($relation_db_keys, $relation_models_keys) ||
                        array_diff($relation_models_keys, $relation_db_keys)
                    ) {
                        $is_dirty_relation = true;
                    }
                }

                if (
                    $is_dirty_relation  ||
                    $db[$model->{$key}]->isDirty()
                ) {
                    $this->output['update'][$class][]= $db[$model->{$key}];
                }
            }
        }

        return $this;
    }

    public function save()
    {
        $files = $this->getOutput();

        if (count($files['error'])) {
            return;
        }

        $output = [];

        // Merge create/update data since they can run the same
        // save operations for model save and relation sync.
        foreach (['create', 'update'] as $op) {
            foreach ($this->output[$op] as $class => $models) {
                if (!isset($output[$class])) {
                    $output[$class] = new Collection;
                }

                $output[$class] = $output[$class]->merge($models);
            }
        }

        // Save create/update models.
        foreach ($output as $class => $models) {
            foreach ($models as $model) {
                // $model->save();
            }
        }

        // Reload all the db data, at this point there
        // should be no new data that is NOT in the db.
        $db = [];

        foreach ($this->relations as $class => $relations) {
            $key = (new $class)->getUniqueKey();

            $db[$class] = $class::with($relations)->get()->keyBy($key);
        }

        // Update create/update relations.
        foreach ($output as $class => $models) {
            foreach ($models as $model) {
                foreach ($model->getRelations() as $relation => $relation_model) {
                    // TODO: Just need to run sync here on the relation with new.
                }
            }
        }

        // Wipe out deletes and associated relations.
        foreach ($this->output['delete'] as $class => $models) {
            foreach ($models as $model) {
                $key      = $model->getUniqueKey();
                $model_db = $db[$model::class][$model->{$key}];

                foreach ($model_db->getRelations() as $relation => $relation_models) {
                    $model_db->{$relation}->delete();
                }

                $model_db->delete();
            }
        }
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

    /*
     * Get current processor name.
     *
     * @return String
     */
    public function getName()
    {
        if ($this->name) {
            return $this->name;
        }

        $name = get_class($this);
        $name = explode('\\', $name);
        $name = end($name);
        $name = strtolower($name);

        return $name;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getPaths()
    {
        return config('larablog.' . $this->name . '.paths');
    }

    public function getParser()
    {
        return config('larablog.' . $this->name . '.parser') ?: $this->parser;
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

    public function isErrors()
    {
        return count($this->output['error']);
    }
}