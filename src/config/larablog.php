<?php

return [

    'doc' => [
        'renderer' => \Websanova\Larablog\Renderers\LarablogMarkdown::class,

        'paths' => [
            //
        ],
    ],

    'post' => [
        'renderer' => '',

        'paths' => [
            //
        ],

        'per_page' => 10,
    ],

    'tables' => [
        'prefix' => '',
    ],
];
