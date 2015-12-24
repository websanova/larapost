<?php

Route::get('/', '\Websanova\Larablog\Http\HomeController@index');

Route::get('/blog', '\Websanova\Larablog\Http\BlogController@index');
Route::get('/{any}', '\Websanova\Larablog\Http\BlogController@post')->where('any', '(.*)');
