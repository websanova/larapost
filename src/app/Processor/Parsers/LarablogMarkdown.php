<?php

namespace Websanova\Larablog\Processor\Parsers;

use Exception;

class LarablogMarkdown
{
    public static function parse(String $contents = '')
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
                $field = preg_split('/\:/', $line);

                if (count($field) !== 2) {
                    throw new Exception('Invalid field at line ' . ($index + 1) . ': ' . $line);
                }

                $key = trim($field[0]);
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