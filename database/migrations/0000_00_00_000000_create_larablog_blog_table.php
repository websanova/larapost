<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarablogBlogTable extends Migration
{
	public function up()
	{
		$prefix = config('larablog.table.prefix');

		Schema::create($prefix . 'posts', function(Blueprint $t)
		{
			$t->increments('id')->unsigned();
			$t->string('identifier', 255)->index();
			$t->string('slug', 255)->unique()->index();
			$t->string('title', 255);
			$t->text('body');
			$t->text('meta');
			$t->string('type', 255)->index();
			$t->enum('status', ['active', 'deleted'])->default('active')->index();
			$t->integer('views_count')->unsigned()->default(0)->index();
			$t->datetime('published_at')->index()->nullable();
			$t->timestamps();

			$t->index('created_at');
			$t->index('updated_at');
		});

		\DB::statement("ALTER TABLE " . $prefix . "posts ADD FULLTEXT KEY " . $prefix . "posts_title_body_fulltext (`title`, `body`)");

		Schema::create($prefix . 'tags', function(Blueprint $t)
		{
			$t->increments('id')->unsigned();
			$t->string('slug', 255)->unique()->index();
			$t->string('name', 255);
			$t->integer('posts_count')->unsigned()->default(0)->index();
			$t->timestamps();

			$t->index('created_at');
			$t->index('updated_at');
		});

		Schema::create($prefix . 'post_tag', function(Blueprint $t)
		{
			$t->integer('post_id')->unsigned()->index();
			$t->integer('tag_id')->unsigned()->index();
		});
	}

	public function down()
	{
		$prefix = config('larablog.table.prefix');

		Schema::drop($prefix . 'post_tag');
		Schema::drop($prefix . 'posts');
		Schema::drop($prefix . 'tags');
	}
}
