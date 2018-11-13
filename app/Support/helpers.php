<?php

if (! function_exists('larablog_view')) {
    /**
     * Shortcut for generating view path with theme.
     *
     * @param  string  $view
     * @return string
     */
    function larablog_view($view)
    {
        return config('larablog.layout.theme') . '.' . $view;
    }
}
