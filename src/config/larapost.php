<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Commonmark
    |--------------------------------------------------------------------------
    |
    | Replace common mark env config options for the default Body field parser.
    |
    */

    'commonmark' => [
        'heading_permalink' => [
            'symbol' => '#',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    |
    | List all the fields for the parser to use. It's important to note that
    | the order may matter here if some fields are dependant on others. For
    | instance (in the default setup) the "Group" field is dependant on
    | the "Doc" field being processed first as the fields are related.
    |
    */

    'fields' => [
        \Websanova\Larapost\Parsers\Fields\Body::class,
        \Websanova\Larapost\Parsers\Fields\Doc::class,
        \Websanova\Larapost\Parsers\Fields\Docs::class,
        \Websanova\Larapost\Parsers\Fields\Demo::class,
        \Websanova\Larapost\Parsers\Fields\Description::class,
        \Websanova\Larapost\Parsers\Fields\Featured::class,
        \Websanova\Larapost\Parsers\Fields\Group::class,
        \Websanova\Larapost\Parsers\Fields\Image::class,
        \Websanova\Larapost\Parsers\Fields\Keywords::class,
        \Websanova\Larapost\Parsers\Fields\Order::class,
        \Websanova\Larapost\Parsers\Fields\Permalink::class,
        \Websanova\Larapost\Parsers\Fields\Published::class,
        \Websanova\Larapost\Parsers\Fields\Redirect::class,
        \Websanova\Larapost\Parsers\Fields\Release::class,
        \Websanova\Larapost\Parsers\Fields\Searchable::class,
        \Websanova\Larapost\Parsers\Fields\Serie::class,
        \Websanova\Larapost\Parsers\Fields\Tags::class,
        \Websanova\Larapost\Parsers\Fields\Title::class,
        \Websanova\Larapost\Parsers\Fields\Updated::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Specify each model that will be used in the build and helper functions.
    | Note that the parser is independant of the build so the keys such as
    | "doc", "group", etc should match if extending the package. Otherwise
    | the build will simply loop through the models calling a "build"
    | funcion. Also note that order here is important as some models
    | may be dependant on having an "id" from a previous model.
    |
    */

    'models' => [
        'doc'   => \Websanova\Larapost\Models\Doc::class,
        'group' => \Websanova\Larapost\Models\Group::class,
        'serie' => \Websanova\Larapost\Models\Serie::class,
        'tag'   => \Websanova\Larapost\Models\Tag::class,
        'post'  => \Websanova\Larapost\Models\Post::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Parser
    |--------------------------------------------------------------------------
    |
    | This value specifies the parser to use which includes functions for both
    | the field and file parsing. This automatically specifies a "post" field
    | which is the only requirement outside of the "field" classes.
    |
    */

    'parser' => \Websanova\Larapost\Parsers\LarapostParser::class,

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Specify fall the paths to process. This will recursively find all files
    | in each directory specified. The file setup will not matter here as
    | all the information for each file (post) is self contained.
    |
    */

    'paths' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | This allows some customization of how the tables are generated.
    |
    */

    'tables' => [
        'prefix' => ''
    ]
];
