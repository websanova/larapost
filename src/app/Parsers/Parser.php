<?php

namespace Websanova\Larablog\Parsers;

class Parser
{
    private $output = [];

    public function errors()
    {
        echo 'errors';
    }

    public function setCreated()
    {

    }

    public function setError()
    {

    }

    public function setUpdated()
    {

    }

    public function getFiles(String $dir = null)
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
                    $files = array_merge($files, $this->getFiles($path));
                }
            }
        }

        return $files;
    }

    public function getFilesInPaths(Array $paths = [])
    {
        $files = [];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $files = array_merge($files, $this->getFiles($path));
            }
        }

        return $files;
    }


    // public $obj = null;

    // public function __call($method, $args)
    // {
    //     if (!$this->obj) {
    //         $this->obj = new $this->model;
    //     }

    //     return call_user_func_array([$this->obj, $method], $args);
    // }
}