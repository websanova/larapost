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
     * Model classes and relations tree for optimized loading.
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
        $data  = [];
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
            $data[$post::class][]= $post;

            foreach ($post->getRelations() as $models) {

                // Gather all classes and relations used on all the raw
                // models. Unfortunately, not much better way to do this
                // dynamically as it needs to come from the raw data set.
                $this->classes[$post::class] = array_unique(array_merge($this->classes[$post::class] ?? [], array_keys($post->getRelations())));

                foreach ($models as $model) {
                    $data[$model::class][]= $model;

                    // Gather from above.
                    if ($post::class !== $model::class) {
                        $this->classes[$model::class] = [];
                    }
                }
            }
        }

        // Compare create/delete/update.
        foreach ($data as $class => $models) {
            $db  = $class::get();
            $key = (new $class)->getUniqueKey();

            $raw = new Collection($models);
            $raw = $raw->unique($key);

            $this->output['create'][$class] = $raw->whereNotIn($key, $db->pluck($key)->toArray());
            $this->output['delete'][$class] = $db->whereNotIn($key, $raw->pluck($key)->toArray());
            $this->output['update'][$class] = [];

            // Updates require a bit of finessing for dirty checks.
            $update = $raw->whereIn($key, $db->pluck($key)->toArray());
            $db = $db->keyBy($key);

            foreach ($update as $model) {
                $db[$model->{$key}]->fill($model->withoutRelations()->toArray());

                if ($db[$model->{$key}]->isDirty()) {
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

        // Merge create/update data.
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
                $model->save();
            }
        }

        // Preload all the db data, at this point there
        // should be no new data that is NOT in the db.
        $db = [];

        foreach ($this->classes as $class => $relations) {
            $key = (new $class)->getUniqueKey();

            $db[$class] = $class::with($relations)->get()->keyBy($key);
        }

        // TODO: Update create/update relations.


        // Wipe out deletes and associated relations.
        foreach ($this->output['delete'] as $class => $models) {
            foreach ($models as $model) {
                $key = $model->getUniqueKey();

                $model = $db[$model::class][$model->{$key}];

                foreach ($model->getRelations() as $relation => $val) {
                    $model->{$relation}->delete();
                }

                $model->delete();
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