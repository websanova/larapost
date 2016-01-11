<?php

foreach (config('larablog.routes') as $k => $v) {
    Route::get($k, $v);
}