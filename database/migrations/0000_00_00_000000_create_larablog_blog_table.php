<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarablogBlogTable extends Migration
{
	public function up()
	{
		$prefix = config('larablog.table.prefix');

		Schema::create($prefix . '_posts', function(Blueprint $t)
		{
			$t->increments('id')->unsigned();
			$t->string('identifier', 255)->index();
			$t->string('slug', 255)->unique()->index();
			$t->string('title', 255);
			$t->text('body');
			$t->text('meta');
			$t->enum('type', ['page', 'post', 'redirect'])->default('post');
			$t->enum('status', ['active', 'deleted'])->default('active')->index();
			$t->integer('views_count')->unsigned()->default(0)->index();
			$t->datetime('published_at')->index()->nullable();
			$t->timestamps();

			$t->index('created_at');
			$t->index('updated_at');
		});

		\DB::statement("ALTER TABLE " . $prefix . "_posts ADD FULLTEXT KEY " . $prefix . "_posts_title_body_fulltext (`title`, `body`)");

		Schema::create($prefix . '_tags', function(Blueprint $t)
		{
			$t->increments('id')->unsigned();
			$t->string('slug', 255)->unique()->index();
			$t->string('name', 255);
			$t->integer('posts_count')->unsigned()->default(0)->index();
			$t->timestamps();

			$t->index('created_at');
			$t->index('updated_at');
		});

		Schema::create($prefix . '_post_tag', function(Blueprint $t)
		{
			$t->integer('post_id')->unsigned()->index();
			$t->integer('tag_id')->unsigned()->index();
		});
	}

	public function down()
	{
		$prefix = config('larablog.table.prefix');

		Schema::drop($prefix . '_post_tag');
		Schema::drop($prefix . '_posts');
		Schema::drop($prefix . '_tags');
	}
}
