<?php

namespace Websanova\Larablog\Processor;

use Exception;
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

        // delete => [],
        // create => [],
        // update => [],
    ];

    /*
     * Output of all models by relation in the build run.
     */
    private $models = [
        // By class name
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
    public function build()
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

    public function save()
    {
        $files = $this->getOutput();
        $posts = Post::get()->keyBy('permalink');

        if (count($files['error'])) {
            return;
        }

        foreach ($files['success'] as $file) {
            $record = [];

            // Collect all the field data.
            foreach ($file as $key => $val) {
                $class = '\\Websanova\\Larablog\\Processor\\Fields\\' . ucfirst(Str::camel($key));

                $record = array_merge($record, $class::parse($record, $file));
            }

            // Clean up special case for relations sets.
            $relations = $record['relations'];

            unset($record['relations']);

            // Create / Update a post.
            if (isset($posts[$record['permalink']])) {
                $post = $posts[$record['permalink']];

                $post->update($record);
            }
            else {
                $post = Post::create($record);
            }

            // Add post to model set.
            $this->models[$post::class][]= $post;

            // Create all model relations and add to model sets.
            foreach ($relations as $key => $models) {
                foreach ($models as $model) {
                    if (!$post->{$key}->contains($model)) {
                        $post->{$key}()->attach($model);
                    }

                    $this->models[$model::class][]= $model;
                }
            }
        }

        // Process create/delete/update
        //  - update => list of ids in $this->models AND in db.
        //  - create => list of ids in $this->models AND NOT in db.
        //  - delete => list of ids in db AND NOT in $this->models.



        // Finally run the deletes for any stale data.


        echo count($ops['Websanova\Larablog\Models\Post']);
        echo count($ops['Websanova\Larablog\Models\Tag']);







        // Finally run our dbs.

        // TODO: Before delete runs need to run the checks below.


        // TODO: This does not have to be done here, just need to store
        //       the values for later output processing if necessary.

        // TODO:
        //  - get list of ids in new
        //  - get list of ids in db
        //  - Run the following comparisons:
        //  - updates => get list of ids in new and in db.
        //  - creates => get list of ids in new and not in db.
        //  - deletes => get list of ids in db and not in new.



        // TODO: Clean up check for deletes
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
}