<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="www.w3.org/2005/Atom">
    
    <title type="text" xml:lang="en">{!! config('larablog.site_name') !!}</title>
    <link type="application/atom+xml" href="{!! htmlspecialchars(config('app.url') . config('larablog.feed_path')) !!}" rel="self"/>
    <link type="text" href="{!! htmlspecialchars(config('app.url')) !!}" rel="alternate"/>
    <updated>{!! htmlspecialchars(@$last->published_at) !!}</updated>
    <id>{!! htmlspecialchars(config('app.url') . config('larablog.site_path')) !!}</id>
    <author>
        <name>{!! htmlspecialchars(config('larablog.site_author')) !!}</name>
    </author>
    
    @foreach ($posts as $p)
        <entry>
            <title>{!! htmlspecialchars($p->title) !!}</title>
            <link href="{!! htmlspecialchars($p->url) !!}"/>
            <updated>{!! htmlspecialchars(date('Y-m-dTH:i:sP', strtotime($p->published_at))) !!}</updated>
            <id>{!! htmlspecialchars($p->url) !!}</id>
            <content type="html">{!! htmlspecialchars($p->meta->description) !!}</content>
        </entry>
    @endforeach
</feed>