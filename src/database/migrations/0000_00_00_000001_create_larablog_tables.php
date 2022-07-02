<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLarablogTables extends Migration
{
    public function up()
    {
        // TODO: Setup proper indexes.

        $prefix = config('larablog.tables.prefix');

        if (!Schema::hasTable($prefix . 'docs'))
        {
            Schema::create($prefix . 'docs', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->string('slug', 255);
                $t->string('name', 255);

                $t->unique('slug');
            });
        }

        if (!Schema::hasTable($prefix . 'groups'))
        {
            Schema::create($prefix . 'groups', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->integer('doc_id')->unsigned();
                $t->string('slug', 255);
                $t->string('name', 255);

                $t->unique('slug');
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

        if (!Schema::hasTable($prefix . 'posts'))
        {
            Schema::create($prefix . 'posts', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->integer('doc_id')->unsigned()->default(0);
                $t->integer('group_id')->unsigned()->default(0);
                $t->integer('serie_id')->unsigned()->default(0);
                $t->integer('redirect_id')->unsigned()->default(0);
                $t->smallInteger('order')->unsigned()->default(0);
                $t->string('permalink', 255);
                $t->string('title', 255)->nullable();
                $t->text('body')->nullable();
                $t->text('description')->nullable();
                $t->text('keywords')->nullable();
                $t->text('searchable')->nullable();
                $t->timestamp('published_at')->nullable();
                $t->timestamp('updated_at')->nullable();
                $t->timestamp('created_at')->nullable();

                $t->unique('permalink');
                // $t->index(['redirect_id', 'order']);
                // $t->index(['redirect_id', 'published_at']);
            });

            \DB::statement("ALTER TABLE " . $prefix . "posts ADD FULLTEXT KEY " . $prefix . "searchable (`searchable`)");
        }

        if (!Schema::hasTable($prefix . 'tags'))
        {
            Schema::create($prefix . 'tags', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->string('slug', 255);
                $t->string('name', 255);

                $t->unique('slug');
            });
        }

        if (!Schema::hasTable($prefix . 'series'))
        {
            Schema::create($prefix . 'series', function(Blueprint $t)
            {
                $t->increments('id')->unsigned();
                $t->string('slug', 255);
                $t->string('name', 255);

                $t->unique('slug');
            });
        }
    }

    public function down()
    {
        $prefix = config('larablog.tables.prefix');

        Schema::dropIfExists($prefix . 'doc');
        Schema::dropIfExists($prefix . 'groups');
        Schema::dropIfExists($prefix . 'post_tag');
        Schema::dropIfExists($prefix . 'posts');
        Schema::dropIfExists($prefix . 'serie');
        Schema::dropIfExists($prefix . 'tags');
    }
}