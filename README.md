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

Navigate to `/blog` and see the default blog page. With no articles there will just be empty pages and 404 not found pages.

**Note:** that with a fresh Laravel install the default `/` path for the `welcome` page should be removed.


## Adding & Updating Posts

Out of the box any post or page should be written using markdown format. By default, post and page markdown files should go in the `./blog/posts` and `./blog/pages` folders respectively.

Once a post or page is written the `larablog:build` command is used to add the new posts and pages or update existing ones.

~~~
> php artisan larablog:build
~~~

The main key used for checking existing posts will be the `identifier` field which by default uses the filename.

The root folder name can also be changed in the config if something other than `./blog` is needed. But keep in mind the `larablog:build` command will always use the `posts` and `pages` sub folders.

**Note:** that the files are in markdown format and that the parser can be changed by overwriting the `Websanova\Larablog\Parser\Field\Body` parser.


## Post & Page Format

The post format should like like the following:

~~~
---
title: Larablog Package Released
keywords: larablog, package, laravel, release
description: Larablog package released for Laravel.
date: Jan 1 2016
tags: Larablog, Laravel
permalink: /blog/laravel/larablog-package-released-for-laravel
redirect_from:
  - /some/old/url
  - /some/old/format.html
---

... Body ...

~~~

You can set any fields in the top section of the file. Any that DO NOT have a parser will just get tossed into a default `meta` field. Otherwise if a parser is found it will run. The parsers can manipulate a `data` object which ultimately get's passed into the `create` method for the `posts` table.

Current parsers that ship are:

* Type (`page`, `post` and `redirect`)
* Title
* Body
* Date (`published_at` date)
* Meta (any field that doesn't have a parser)
* Permalink (`slug`)
* RedirectFrom
* Tags
* Buttons
* Identifier


## Config

The best way to get a sense of the config options is to just publish the config and take a look.

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

To set a theme set the 'larablog.theme' property in the config. To simplify things ALL views should simply use `larablog::theme.master` as the main view. Then a `view` is set as part of the data sent to the view.

```
return view('larablog::themes.master', [
    'view' => lb_view('post.show'),
]);
```

The `lb_view` is a shortcut helper to use to avoid having to set the full path with the theme each time. This allows easy swapping of themes by only having to change the config parameter.

So far the currently supported themes are:

* default


## Overriding Layouts

In many cases you will want to add some customization to the layout to include some analytics tracking or ads for instance. To allow this the themes include many section blocks that can replace or modify existing layout.

To start, create an `overrides` file in the views directory.

```
> /resources/views/vendor/larablog/themes/overrides.blade.php
```

From there the following section blocks can be used which hopefully are self explanatory.

* `meta.opensearch`
* `meta.title`
* `meta.keywords`
* `meta.description`
* `meta.og`
* `head.files`
* `head.styles`
* `sidebar.series`
* `sidebar.popular`
* `component.search`
* `component.related`
* `footer-nav.left`
* `footer-nav.right`
* `post.list`
* `post.head`
* `post.series`
* `post.body`
* `post.related`
* `page.head`
* `page.body`
* `layout.view`
* `layout.end`


## Customize

For customization the `Larablog` facade may be used.

~~~
'aliases' => [
  'Blog'      => Websanova\Larablog\Facades\LarablogFacade::class,
  ...
]
~~~

The facade provides access to the following shortcut functions:

* **`published()`** - Paginated list of posts.
* **`search($q)`** - Paginated list of posts by search.
* **`all()`** - All posts.
* **`last()`** - Last post (by published_at date).
* **`post($slug)`** - Post or page by slug.
* **`count()`** - Post count.
* **`top($amount)`** - Top posts (default 10).
* **`tags()`** - All tags.
* **`publishedWhereTag($tag)`** - Paginated list of posts by tag.


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


## Headers & Footers

Each theme should also support a header and footer section (and perhaps more standard sections to follow). The idea is that a list of views can be provided and they will be included in that order.

This allows the inclusion of any ads or analytics tracking codes.


## Adding Parser

To add a parser, create a class with the name of the key being parsed. So `title` would look for `Websanova\Larablog\Parser\Field\Title`. This way additional fields may be added or existing ones overridden.


## To Do

Some things that still need to be done.

* Auto build/post hook.
* Related articles matching.
* Comments.
* Backend Admin (with MD editor).

Would also be nice to have some kind of plugin architecture. For instance some kind of SEO plugin. Although not sure how this would work quite yet.