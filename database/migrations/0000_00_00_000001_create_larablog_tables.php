<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarablogTables extends Migration
{
	public function up()
	{
		$prefix = config('larablog.table.prefix');

		if (!Schema::hasTable($prefix . 'posts'))
		{
			Schema::create($prefix . 'posts', function(Blueprint $t)
			{
				$t->increments('id')->unsigned();
				$t->integer('serie_id')->unsigned()->default(0)->index();
				$t->integer('doc_id')->unsigned()->default(0)->index();
				$t->string('type', 255)->index();
				$t->integer('order')->unsigned()->default(0)->index();
				$t->string('identifier', 255)->index();
				$t->string('slug', 255)->unique()->index();
				$t->string('title', 255);
				$t->text('body');
				$t->text('meta');
				$t->integer('views_count')->unsigned()->default(0)->index();
				$t->timestamp('published_at')->nullable()->index();
				$t->timestamp('deleted_at')->nullable()->index();
				$t->timestamp('updated_at')->nullable()->index();
				$t->timestamp('created_at')->nullable()->index();
			});

			\DB::statement("ALTER TABLE " . $prefix . "posts ADD FULLTEXT KEY " . $prefix . "posts_title_body_fulltext (`title`, `body`)");
		}

		if (!Schema::hasTable($prefix . 'tags'))
		{
			Schema::create($prefix . 'tags', function(Blueprint $t)
			{
				$t->increments('id')->unsigned();
				$t->string('slug', 255)->unique()->index();
				$t->string('name', 255);
				$t->integer('posts_count')->unsigned()->default(0)->index();
				$t->timestamp('updated_at')->nullable()->index();
				$t->timestamp('created_at')->nullable()->index();
			});
		}

		if (!Schema::hasTable($prefix . 'post_tag'))
		{
			Schema::create($prefix . 'post_tag', function(Blueprint $t)
			{
				$t->integer('post_id')->unsigned()->index();
				$t->integer('tag_id')->unsigned()->index();
			});
		}

		if (!Schema::hasTable($prefix . 'series'))
		{
			Schema::create($prefix . 'series', function(Blueprint $t)
	        {
	            $t->increments('id')->unsigned();
	            $t->string('slug', 255)->unique()->index();
	            $t->string('title', 255);
	            $t->string('type', 255)->index();
	            $t->integer('posts_count')->unsigned()->default(0)->index();
	            $t->timestamp('updated_at')->nullable()->index();
				$t->timestamp('created_at')->nullable()->index();
	        });
		}

		// if (!Schema::hasTable($prefix . 'docs'))
		// {
		// 	Schema::create($prefix . 'docs', function(Blueprint $t)
	 //        {
	 //            $t->increments('id')->unsigned();
	 //            $t->string('slug', 255)->unique()->index();
	 //            $t->string('title', 255);
	 //            $t->integer('posts_count')->unsigned()->default(0)->index();
	 //            $t->timestamp('updated_at')->nullable()->index();
		// 		$t->timestamp('created_at')->nullable()->index();
	 //        });
		// }

		// if (!Schema::hasTable($prefix . 'sections'))
		// {
		// 	Schema::create($prefix . 'sections', function(Blueprint $t)
	 //        {
	 //            $t->increments('id')->unsigned();
	 //            $t->integer('chapter_id')->unsigned()->index();
	 //            $t->string('slug', 255)->unique()->index();
	 //            $t->string('title', 255);
	 //            $t->string('type', 255);
	 //            $t->integer('sections_count')->unsigned()->default(0)->index();
	 //            $t->timestamp('updated_at')->nullable()->index();
		// 		$t->timestamp('created_at')->nullable()->index();
	 //        });
		// }
	}

	public function down()
	{
		$prefix = config('larablog.table.prefix');

		Schema::dropIfExists($prefix . 'post_tag');
		Schema::dropIfExists($prefix . 'posts');
		Schema::dropIfExists($prefix . 'tags');
		Schema::dropIfExists($prefix . 'series');
		// Schema::dropIfExists($prefix . 'docs');
		// Schema::dropIfExists($prefix . 'sections');
	}
}
