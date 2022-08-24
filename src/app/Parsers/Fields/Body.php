<?php

namespace Websanova\Larapost\Parsers\Fields;

use Exception;
use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\MarkdownConverter;

class Body
{
    public static function parse(String $name, Array $data, Array $parse)
    {
        if (!isset($parse['body'])) {
            throw new Exception('body is required.');
        }

        if (empty($parse['body'][0])) {
            throw new Exception('Body is empty.');
        }

        $env = new Environment(array_replace_recursive([
            'heading_permalink' => [
                'aria_hidden'       => true,
                'fragment_prefix'   => '',
                'html_class'        => 'permalink',
                'id_prefix'         => '',
                'insert'            => 'before',
                'max_heading_level' => 6,
                'min_heading_level' => 1,
                'symbol'            => '',
                'title'             => '',
            ],
        ], config('larapost.commonmark', [])));

        $env->addExtension(new CommonMarkCoreExtension());
        $env->addExtension(new GithubFlavoredMarkdownExtension());
        $env->addExtension(new HeadingPermalinkExtension());

        $converter = new MarkdownConverter($env);

        $body = (string) $converter->convert($parse['body'][0]);

        $data['post'][$name]->attributes['body'] = $body;

        return $data;
    }
}