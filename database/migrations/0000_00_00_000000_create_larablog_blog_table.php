<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarablogBlogTable extends Migration
{
	public function up()
	{
		Schema::create(config('larablog.table'), function(Blueprint $t)
		{
			$t->increments('id')->unsigned();
			$t->string('slug', 255)->unique()->index();
			$t->string('title', 255);
			$t->text('body');
			$t->text('meta');
			$t->enum('type', ['page', 'post', 'redirect'])->default('post');
			$t->datetime('published_at')->index()->nullable();
			$t->timestamps();

			$t->index('created_at');
			$t->index('updated_at');
		});

		\DB::statement("ALTER TABLE " . config('larablog.table') . " ADD FULLTEXT KEY posts_fulltext (`" . implode('`, `', config('larablog.search_fields')) . "`)");
	}

	public function down()
	{
		Schema::drop(config('larablog.table'));
	}
}
