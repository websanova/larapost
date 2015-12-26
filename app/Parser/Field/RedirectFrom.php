<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Models\Blog;

class RedirectFrom
{
	public static function process($key, $val, $data)
	{
        return $data;
	}

	public static function handle($key, $val, $post)
	{
		if ( ! is_array($val)) {
			$val = [$val];
		}

		// TODO: delete redirects that don't exist anymore.

		foreach ($val as $redirect_from) {
			$redirect = Blog::where('slug', $redirect_from)->first();

			$data = [
				'slug' => $redirect_from,
				'title' => '',
				'body' => '',
				'type' => 'redirect',
				'meta' => json_encode([
					'redirect_to' => $post->slug
				])
			];

			if ($redirect) {
				$redirect->fill($data);

				if ($redirect->isDirty()) {
					$redirect->save();
					echo 'Update Redirect: ' . $redirect_from . "\n";
				}
			}
			else {
				$post = Blog::create($data);

				echo 'New Redirect: ' . $redirect_from . "\n";
			}
		}
	}
}