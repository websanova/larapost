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
     * Output of build parsing error/success and deletes/inserts/updates.
     */
    private $output = [
        'delete'  => [],
        'error'   => [],
        'insert'  => [],
        'success' => [],
        'update'  => [],
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

        $output = [];

        foreach ($files as $file) {
            $parse  = $this->getParsed($file);
            $result = isset($parse['error']) ? 'error' : 'success';

            $output[$result][$file] = $parse;
        }

        $this->output = $output;

        // TODO: Check for error.
        //       - error out here and display only.

        // TODO: Run through each files fields to convert to model update/create.

        return $this;
    }

    public function save()
    {
        $files = $this->getOutput();

        foreach ($files['success'] as $file) {
            $record = [];

            foreach ($file as $key => $val) {
                $class = '\\Websanova\\Larablog\\Processor\\Fields\\' . ucfirst(Str::camel($key));

                $record = array_merge($record, $class::parse($record, $file));
            }

            // print_r($record);
        }

        $relations = $record['relations'];

        unset($record['relations']);

        $post = Post::create($record);

        echo $post->id;


        // TODO: Process relations (which will be by model so it should all be automagical).
        // as createOrUpdate then attach
        // ex. $post->tags()->save($tag) ??? something like that...???



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