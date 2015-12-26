# Larablog

If you're like me and got annoyed from using WordPress and GitHub pages and you also Like Laravel, then this blogging plugin is for you.

The idea is to keep your blog content in the `.md` files so they can be moved around to other platforms. This just being one of the options.

__ * For now this is a project for myself, if there is some interest I will work on more of the todo's. Otherwise I will just go along as need by for myself.__


## Installing

--include
--service provider...


## Migrations

The migration can be run directly from the packages `migrations` folder.

~~~
> php artisan migrate --path=/packages/websanova/larablog/src/migrations
> php artisan migrate:rollback
~~~

If it needs to be run as part of the regular `php artisan migrate` use the `vendor:publish` command.


## Publishing

Publish all files from package.

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


## Write

If you use the default then articles will just go in the `/blog` folder in the root of your project.

~~~
> php artisan larablog:reset
~~~


## Config

Best way to get a sense of the options is to just publish the config and take a look.

## Meta

Many of the tags for display items on a page can be overwritten in any controller method by simply setting the variable in the data associated with the view. Current options are.

### Meta

* img
* keywords
* description
* title
* type
* slug

We will try to use appropriate defaults wherever we can.


## Themes

You can write your own view as a theme and just set it in the `larablog.theme` setting. That is if you want to use the existing controllers. You of course have all the flexibility you need.

So for the currently supported themes are:

* default


## To Do

Some things that still need to be done.

* Auto build hook.
* Tags
* Related articles matching.
* Comments
* Most popular
* Maybe a backend admin with a Markdown editor.

Would also be nice to have some kind of plugin architecture. For instance some kind of SEO plugin. Although not sure how this would work quite yet.


## Default Parsers

There are only two default parsers. One for processing the `body` content. The other one is a general `meta` parser for any fields missing a parser. The `meta` fields all get put into a `meta` array field.


## Adding Parser

If you want to add your own parsers you can create your own parser class with the name of the key. So `title` would look for `Websanova\Larablog\Parser\Title`. This allows you to easily add any additional fields you may need if you need to modify the table or perform some other operations.

You can also overwrite parsers in this some way. Most of the time this should be ok. For now you can not extend parsers because there is no class mapping for the fields.