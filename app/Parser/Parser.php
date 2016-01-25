<?php

namespace Websanova\Larablog\Parser;

class Parser
{
	public static function parse($file)
	{
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s', file_get_contents($file), $m);
        
        // Parse the head first
        $data = [
            'body' => $m[2]
        ];
        
        $last = '';
        $head = explode("\n", trim($m[1]));

        foreach ($head as $h) {
            $h = trim($h);

            if (substr(trim($h), 0, 1) === '-' && ! empty($last)) {
                if ( ! is_array($data[$key])) {
                    $data[$key] = [];
                }

                $key = $last;
                $val = trim(trim(trim($h), '-'));

                array_push($data[$key], $val);
            }
            elseif (preg_match('/(.*?)\:(.*)/', $h, $m)) {
                $key = trim($m[1]);
                $val = trim($m[2]);
                $data[$key] = $val;
                $last = $key;
            }
        }

        return $data;
	}

    public static function process($fields)
    {
        $data = [];

        foreach ($fields as $key => $val) {
            $class = 'Websanova\Larablog\Parser\Field\\' . ucfirst(camel_case($key));

            // Call class or default to Meta.
            if (class_exists($class) && method_exists($class, 'process')) {
                $data = $class::process($key, $val, $data);
            }
            else {
                $data = \Websanova\Larablog\Parser\Field\Meta::process($key, $val, $data);
            }
        }

        return $data;
    }

    public static function handle($fields, $post)
    {
        foreach ($fields as $key => $val) {
            $class = 'Websanova\Larablog\Parser\Field\\' . ucfirst(camel_case($key));

            if (class_exists($class) && method_exists($class, 'handle')) {
                $class::handle($key, $val, $post);
            }
        }
    }
}