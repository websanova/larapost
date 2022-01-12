<?php

namespace Websanova\Larablog\Parsers;

use Exception;
use Websanova\Larablog\Renderers\LarablogMarkdown;

class Parser
{
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

    public function getOutput()
    {
        return $this->output;
    }

    public function handle(Array $paths = [])
    {
        $data  = [];
        $files = $this->getFiles($paths);

        foreach ($files as $file) {
            $parse  = $this->parse($file);
            $result = isset($parse['error']) ? 'error' : 'success';

            $data[$result][$file] = $parse;
        }

        return $data;
    }

    public function parse(String $file = null)
    {
        if (is_file($file)) {
            $contents = file_get_contents($file);

            try {
                return LarablogMarkdown::parse($contents);
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