<?php

namespace Websanova\Larablog\Http;

use Request;
use Websanova\Larablog\Models\Blog;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $total = Blog::count();

		return view('larablog::home.index', ['total' => $total]);
    }
}