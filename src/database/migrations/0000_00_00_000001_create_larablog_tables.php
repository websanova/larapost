<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarablogTables extends Migration
{
    public function up()
    {
        // TODO: Setup proper indexes.

        $prefix = config('larablog.tables.prefix');

        if (!Schema::hasTable($prefix . 'posts'))
        {
            Schema::create($prefix . 'posts', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->integer('redirect_id')->unsigned()->default(0);
                $t->smallInteger('order')->unsigned()->default(0);
                $t->string('permalink', 255)->unique();
                $t->string('title', 255)->nullable();
                $t->text('searchable')->nullable();
                $t->text('body')->nullable();
                $t->text('meta')->nullable();
                $t->timestamp('published_at')->nullable();
                $t->timestamp('updated_at')->nullable();
                $t->timestamp('created_at')->nullable();
            });

            $t->index(['redirect_id', 'order']);
            $t->index(['redirect_id', 'published_at']);

            \DB::statement("ALTER TABLE " . $prefix . "posts ADD FULLTEXT KEY " . $prefix . "searchable (`searchable`)");
        }

        if (!Schema::hasTable($prefix . 'tags'))
        {
            Schema::create($prefix . 'tags', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->string('slug', 255)->unique();
                $t->string('name', 255);
                $t->integer('posts_count')->unsigned()->default(0);
                $t->timestamp('updated_at')->nullable();
                $t->timestamp('created_at')->nullable();
            });
        }

        if (!Schema::hasTable($prefix . 'post_tag'))
        {
            Schema::create($prefix . 'post_tag', function(Blueprint $t)
            {
                $t->integer('post_id')->unsigned();
                $t->integer('tag_id')->unsigned();
            });
        }

        if (!Schema::hasTable($prefix . 'groups'))
        {
            Schema::create($prefix . 'groups', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->string('slug', 255)->unique();
                $t->string('title', 255);
                $t->string('type', 255);
                $t->integer('posts_count')->unsigned()->default(0);
                $t->timestamp('updated_at')->nullable();
                $t->timestamp('created_at')->nullable();
            });
        }
    }

    public function down()
    {
        $prefix = config('larablog.tables.prefix');

        Schema::dropIfExists($prefix . 'groups');
        Schema::dropIfExists($prefix . 'post_tag');
        Schema::dropIfExists($prefix . 'tags');
        Schema::dropIfExists($prefix . 'posts');
    }
}