<?php

namespace Websanova\Larablog\Processor;

use Exception;

class Processor
{
    public $name = null;

    public function __construct()
    {
        if (!$this->name) {
            $this->name = $this->getName();
        }
    }

    public function build()
    {
        $paths = $this->getPaths();

        $data  = [];
        $files = $this->getFiles($paths);

        foreach ($files as $file) {
            $parse  = $this->parse($file);
            $result = isset($parse['error']) ? 'error' : 'success';

            $data[$result][$file] = $parse;
        }

        print_r($data);

        return $data;
    }

    public function getError(String $code, String $msg)
    {
        return [
            'error' => [
                'code' => $code,
                'msg'  => $msg,
            ]
        ];
    }

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

    public function getName()
    {
        $name = get_class($this);
        $name = explode('\\', $name);
        $name = end($name);
        $name = str_replace('Parser', '', $name);
        $name = strtolower($name);

        return $name;
    }

    public function getPaths()
    {
        return config('larablog.' . $this->name . '.paths');
    }

    public function getParser()
    {
        return config('larablog.' . $this->name . '.parser');
    }

    public function parse(String $file = null)
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