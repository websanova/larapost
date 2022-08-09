<?php

return [

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

    'parser' => \Websanova\Larablog\Parsers\LarablogParser::class,

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
        \Websanova\Larablog\Parsers\Fields\Body::class,
        \Websanova\Larablog\Parsers\Fields\Date::class,
        \Websanova\Larablog\Parsers\Fields\Doc::class,
        \Websanova\Larablog\Parsers\Fields\Docs::class,
        \Websanova\Larablog\Parsers\Fields\Demo::class,
        \Websanova\Larablog\Parsers\Fields\Description::class,
        \Websanova\Larablog\Parsers\Fields\Featured::class,
        \Websanova\Larablog\Parsers\Fields\Group::class,
        \Websanova\Larablog\Parsers\Fields\Image::class,
        \Websanova\Larablog\Parsers\Fields\Keywords::class,
        \Websanova\Larablog\Parsers\Fields\Order::class,
        \Websanova\Larablog\Parsers\Fields\Permalink::class,
        \Websanova\Larablog\Parsers\Fields\Redirect::class,
        \Websanova\Larablog\Parsers\Fields\Release::class,
        \Websanova\Larablog\Parsers\Fields\Searchable::class,
        \Websanova\Larablog\Parsers\Fields\Serie::class,
        \Websanova\Larablog\Parsers\Fields\Tags::class,
        \Websanova\Larablog\Parsers\Fields\Title::class,
    ],

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
        'doc'   => \Websanova\Larablog\Models\Doc::class,
        'group' => \Websanova\Larablog\Models\Group::class,
        'serie' => \Websanova\Larablog\Models\Serie::class,
        'tag'   => \Websanova\Larablog\Models\Tag::class,
        'post'  => \Websanova\Larablog\Models\Post::class,
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
