
// TODO:



Can use models directly \Websanova\Larablog\Models\Doc

or use helper methods which automagically route to models specified in config

\Websanova\Larablog\Larablog::doc()->all()

- everything else is done in the models, so you can extend override, etc via config and still use the Larablog to route through.



- markdown / rendering on page.
- serie as tag
- doc as post





// The first run just gathers up all the data/posts so no changes are made if there is an error.


// LMD Larablog Markdown Format (pretty much markdown but with a header and some rendering mods for better linking).




It's been designed to be as dynamic and automagical as possible for creating new fields and relations around posts. For instance the tags and docs don't require any special coding and other such relations that make sense should be addable.


The diff command is especially useful is it allows us to first see any changes to our entire structure before actually running any saves.




