<?php

namespace Websanova\Larablog\Http;

use Websanova\Larablog\Larablog;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $total = Larablog::count();

		return view('larablog::themes.default', [
			'view' => 'larablog::home.index',
			'total' => $total
		]);
    }
}