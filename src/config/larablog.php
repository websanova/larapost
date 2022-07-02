<?php

return [

    'parser' => \Websanova\Larablog\Parsers\LarablogParser::class,

    'fields' => [
        \Websanova\Larablog\Parsers\Fields\Body::class,
        \Websanova\Larablog\Parsers\Fields\Doc::class,
        \Websanova\Larablog\Parsers\Fields\Description::class,
        \Websanova\Larablog\Parsers\Fields\Group::class,
        \Websanova\Larablog\Parsers\Fields\Keywords::class,
        \Websanova\Larablog\Parsers\Fields\Order::class,
        \Websanova\Larablog\Parsers\Fields\Permalink::class,
        \Websanova\Larablog\Parsers\Fields\Redirects::class,
        \Websanova\Larablog\Parsers\Fields\Searchable::class,
        \Websanova\Larablog\Parsers\Fields\Serie::class,
        \Websanova\Larablog\Parsers\Fields\Tags::class,
        \Websanova\Larablog\Parsers\Fields\Title::class,
    ],

    'paths' => [
        // All directories here will be recursively searched for all files.
    ],

    'models' => [
        'doc'   => \Websanova\Larablog\Models\Doc::class,
        'group' => \Websanova\Larablog\Models\Group::class,
        'post'  => \Websanova\Larablog\Models\Post::class,
        'serie' => \Websanova\Larablog\Models\Serie::class,
        'tag'   => \Websanova\Larablog\Models\Tag::class,
    ],

    'tables' => [
        'prefix' => ''
    ]
];
