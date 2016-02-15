<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Larablog;
use Illuminate\Support\Facades\DB;
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

		if (count($diff) > 0) {
			echo 'Updated Tags: ' . $val . "\n";
		}
	}

	public function cleanup()
	{
		$prefix = config('larablog.table.prefix');

        // Clean out any old pivot data.
        DB::statement("DELETE {$prefix}_post_tag FROM {$prefix}_post_tag LEFT JOIN {$prefix}_posts ON {$prefix}_post_tag.post_id = {$prefix}_posts.id WHERE NOT({$prefix}_post_tag.post_id = {$prefix}_posts.id AND {$prefix}_posts.status = 'active' AND {$prefix}_posts.type='post')");

        // TODO: convert to eloquent?
        DB::table($prefix . '_tags')->update([
            'posts_count' => DB::Raw("(SELECT COUNT(*) FROM {$prefix}_post_tag WHERE {$prefix}_post_tag.tag_id = {$prefix}_tags.id)")
        ]);
        
        Tag::where('posts_count', 0)->delete();
	}
}