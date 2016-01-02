# LaraBlog

A simple blogging package powered by Laravel.

The package can be used standalone without writing any code. However, as a Laravel package it comes with all the Laravel goodness allowing more organized customization compared to a traditional CMS systems like WordPress.

LaraBlog is still a new package. For any bugs, or feature requests please contact me at [rob@websanova.com](mailto:rob@websanova.com)


## Installing

Include the package.

~~~
composer require "websanova/larablog"
~~~

Add provider to `config/app`.

~~~
'providers' => [
	Websanova\Larablog\Providers\LarablogServiceProvider::class,
	...
]
~~~

Migrate the LaraBlog tables.

~~~
php artisan migrate --path=/vendor/websanova/larablog/database/migrations
~~~

You can now navigate to `/blog` and see the default blog page. With no articles you will just see empty pages and 404 not found pages.

Also note that if you have a fresh install you will need to go to your routes file and remove the default `/` path for the `welcome` page.


## Adding &amp; Updating Posts

Posts should go in the folder specified by the config, by default `./blog` folder. You can the run the `larablog:build` command to add new posts and update existing ones.

~~~
> php artisan larablog:build
~~~

The main key used for checking existing posts will be the `permalink` field.

Note that the files are in markdown format and you can change the parser by overwriting the `Websanova\Larablog\Parser\Field\Body` parser.


## Post Format &amp; Fields

The post format should like like the following:

~~~
---
title: Larablog Package Released
keywords: larablog, package, laravel, release
description: Larablog package released for Laravel.
date: Jan 1 2016
permalink: /blog/laravel/larablog-package-released-for-laravel
tags: Larablog, Laravel
redirect_from:
  - /some/old/url
  - /some/old/format.html
---

... Body ...

~~~

You can set any fields in the top section of the file. Any that DO NOT have a parser will just get tossed into a default `meta` field. Otherwise if a parser is found it will run. The parsers can manipulate a `data` object which ultimately get's passed into the `create` method for the the `posts` table.

Current parsers that ship are:

* Type (`page` or `post`)
* Title
* Body
* Date (`published_at` date)
* Meta
* Permalink (`slug`)
* RedirectFrom
* Tags


## Pages

Pages work the same way as posts do, but need to have the type field set to `page`.

~~~
---
type: page

...

---
~~~

In there, the same fields can be set such as `keywords`, `img`, `redirect_from`. It can also be used simply as a redirect system for pages coded directly in Laravel that need a simple way to setup redirects.


## Config

Best way to get a sense of the options is to just publish the config and take a look.

~~~
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider" --tag=config
~~~


## Migrations

The migration can be run directly from the packages `migrations` folder.

~~~
> php artisan migrate --path=/vendor/websanova/larablog/database/migrations
> php artisan migrate:rollback
~~~

If it needs to be run as part of the regular `php artisan migrate` use the `vendor:publish` command.

~~~
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider" --tag=migrations
~~~


## Themes

The theme works as one source view that is set. That view should then accept an argument for what view to load and assemble the page. The theme can be set through the config with the `larablog.theme` property.

So for the currently supported themes are:

* default


## Customize

If you want to customize things you may want to also use the `Larablog` facade.

~~~
'aliases' => [
  'Blog'      => Websanova\Larablog\Facades\LarablogFacade::class,
  ...
]
~~~

This provides access to the following quick reference functions:

* **`published()`** - Paginated list of posts.
* **`search($q)`** - Paginated list of posts by search.
* **`all()`** - All posts.
* **`last()`** - Last post (by published_at date).
* **`post($slug)`** - Post or page by slug.
* **`count()`** - Post count.
* **`top($amount)`** - Top posts (default 10).
* **`tags()`** - All tags.
* **`publishedWhereTag($tag)`** - Paginated list of posts by tag.

You can overwrite the controller methods or write your own to get the functionality you like.


## Assets

Publish all files from the package.

~~~
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider"
~~~

Or publish separately.

~~~
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider" --tag=migrations
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider" --tag=views
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider" --tag=config
> php artisan vendor:publish --provider="Websanova\Larablog\Providers\LarablogServiceProvider" --tag=assets
~~~


## View Meta

Many of the tags for display items on a page can be overwritten in any controller method by simply setting the variable in the data associated with the view.

Current options are:

* img
* keywords
* description
* title
* type
* slug

~~~
function index() {
	$content = view('larablog::blog.index', [
		'img' => '/path/to/img',
		...
	]);
}

~~~

Appropriate defaults are used already wherever possible so these shouldn't have to be set for the most part.


## Headers &amp; Footers

Each theme should also support a header and footer section (and perhaps more standard sections to follow). The idea is that a list of views can be provided and they will be included in that order.

This allows the inclusion of any ads or analytics tracking codes.


## Adding Parser

If you want to add your own parsers you can create your own parser class with the name of the key. So `title` would look for `Websanova\Larablog\Parser\Title`. This allows you to easily add any additional fields you may need if you need to modify the table or perform some other operations.

You can also overwrite parsers in this some way. Most of the time this should be ok. For now you can not extend parsers because there is no class mapping for the fields.


## To Do

Some things that still need to be done.

* Auto build/post hook.
* Related articles matching.
* Comments.
* Backend Admin (with MD editor).

Would also be nice to have some kind of plugin architecture. For instance some kind of SEO plugin. Although not sure how this would work quite yet.