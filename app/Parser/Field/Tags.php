<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Tag;

class Tags
{
	public static function process($key, $val, $data)
	{
        return $data;
	}

	public static function handle($key, $val, $post)
	{
		$tag_list = explode(',', $val);
		
		$tags = [];

		foreach ($tag_list as $v) {
			$v = trim($v);

			if (empty($v)) {
				continue;
			}

			$slug = str_slug($v);
			
			$tag = Tag::where('slug', $slug)->first();

			if ( ! $tag) {
				$tag = Tag::create([
					'slug' => $slug,
					'name' => $v
				]);
			}

			array_push($tags, $tag);
		}
		
		$tags_old = $post->tags->lists('id')->toArray();
		$tags_new = array_map(function ($v) { return $v->id; }, $tags);

		$diff = array_merge(array_diff($tags_old, $tags_new), array_diff($tags_new, $tags_old));

		$post->tags()->sync($tags_new);

		foreach ($tags as $t) {
			$t->posts_count = Larablog::publishedWhereTag($t)->count();
			$t->save();
		}

		if (count($diff) > 0) {


			echo 'Updated Tags: ' . $val . "\n";
		}
	}
}