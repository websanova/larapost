<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="www.w3.org/2005/Atom">    
    <title type="text" xml:lang="en">{!! config('larablog.site.name') !!}</title>
    <link type="application/atom+xml" href="{!! htmlspecialchars(route('feed')) !!}" rel="self"/>
    <link type="text" href="{!! htmlspecialchars(url('/')) !!}" rel="alternate"/>
    <updated>{!! htmlspecialchars(date('c', strtotime(@$last->published_at))) !!}</updated>
    <id>{!! htmlspecialchars(route('blog')) !!}</id>
    <author>
        <name>{!! htmlspecialchars(config('larablog.site.author')) !!}</name>
    </author>
   
    @foreach ($posts as $p)
        <entry>
            <title>{!! htmlspecialchars($p->full_title) !!}</title>
            <link href="{!! htmlspecialchars($p->url) !!}"/>
            <updated>{!! htmlspecialchars(date('c', strtotime($p->published_at))) !!}</updated>
            <id>{!! htmlspecialchars($p->url) !!}</id>
            <content type="html">{!! htmlspecialchars($p->meta->description) !!}</content>
        </entry>
    @endforeach
</feed>