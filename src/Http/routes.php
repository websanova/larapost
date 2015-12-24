<?php

Route::get('/', '\Websanova\Larablog\Http\HomeController@index');

Route::get(config('larablog.site.path'), '\Websanova\Larablog\Http\BlogController@index');
Route::get(config('larablog.search.path'), '\Websanova\Larablog\Http\BlogController@search');
Route::get('/{any}', '\Websanova\Larablog\Http\BlogController@post')->where('any', '(.*)');
