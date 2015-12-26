<?php

namespace Websanova\Larablog\Markdown;

class Markdown
{
    public function __construct()
    {
        require_once base_path() . '/vendor/michelf/php-markdown/Michelf/Markdown.inc.php';
    }

    public static function extra($s)
    {
        return \Michelf\MarkdownExtra::defaultTransform($s);
    }

    public static function standard($s)
    {
        return \Michelf\Markdown::defaultTransform($s);
    }
}