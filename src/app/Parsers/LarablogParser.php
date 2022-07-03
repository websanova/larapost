<?php

namespace Websanova\Larablog\Parsers;

use Exception;
use Illuminate\Support\Facades\File;

class LarablogParser
{
    public static function getData()
    {
        $data  = [];
        $paths = config('larablog.paths');

        foreach ($paths as $path) {
            $files = File::allFiles($path);

            foreach ($files as $file) {
                $name = $file->getPathname();

                $data['posts'][$name] = (object)[];

                try {
                    $parse = self::parseContents($file->getContents());

                    foreach (config('larablog.fields') as $class) {
                        $data = $class::parse($name, $data, $parse);
                    }
                }
                catch(Exception $e) {
                    unset($data['posts'][$name]);

                    $data['errors'][]= [
                        'msg'  => $e->getMessage(),
                        'name' => $name,
                    ];

                    continue;
                }
            }
        }

        return $data;
    }

    private static function parseContents(String $contents = '')
    {
        $data = [];

        $is_end = false;
        $lines  = preg_split("/\n|\n\r/", $contents);

        foreach ($lines as $index => $line) {

            // Trim all header content.
            if (!$is_end) {
                $line = trim($line);
            }

            // First line must be "---".
            if ($index === 0) {
                if ($line !== '---') {
                    throw new Exception('Missing opening "---" at line ' . ($index + 1) . ': ' . $line);
                }

                continue;
            }

            // Find closing "---".
            if ($line === '---') {
                $is_end = true;

                continue;
            }

            // Parse field into key/val.
            if (!$is_end) {
                $field = preg_split('/\:/', $line, 2);

                if (count($field) !== 2) {
                    throw new Exception('Invalid field at line ' . ($index + 1) . ': ' . $line);
                }

                $key = trim($field[0]);
                $key = strtolower($key);
                $val = trim($field[1]);

                if (empty($key) || empty($val)) {
                    throw new Exception('Invalid field at line ' . ($index + 1) . ': ' . $line);
                }

                $data[$key][]= $val;

                continue;
            }

            $data['body'][]= $line;
        }

        if (!$is_end) {
            throw new Exception('Missing closing "---" at line ' . ($index + 2));
        }

        $data['body'] = [
            implode("\n", $data['body'])
        ];

        return $data;
    }
}