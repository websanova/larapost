# Larablog

If you're like me and got annoyed from using WordPress and GitHub pages and you also Like Laravel, then this blogging plugin is for you.

The idea is to keep your blog content in the `.md` files so they can be moved around to other platforms. This just being one of the options.

__ * For now this is a project for myself, if there is some interest I will work on more of the todo's. Otherwise I will just go along as need by for myself.__

## Migrations

~~~
> php artisan migrate --path=/packages/websanova/larablog/src/migrations
> php artisan migrate:rollback
~~~


## Config

Coming soon...


## To Do

Some things that still need to be done.

* Auto build hook.
* Tags
* Related articles matching.
* Comments
* Most popular
* Themes
* Maybe a backend admin with a Markdown editor.

Would also be nice to have some kind of plugin architecture. For instance some kind of SEO plugin. Although not sure how this would work quite yet.


## Default Parsers

There are only two default parsers. One for processing the `body` content. The other one is a general `meta` parser for any fields missing a parser. The `meta` fields all get put into a `meta` array field.


## Adding Parser

If you want to add your own parsers you can create your own parser class with the name of the key. So `title` would look for `Websanova\Larablog\Parser\Title`. This allows you to easily add any additional fields you may need if you need to modify the table or perform some other operations.

You can also overwrite parsers in this some way. Most of the time this should be ok. For now you can not extend parsers because there is no class mapping for the fields.