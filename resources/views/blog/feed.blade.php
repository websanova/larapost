<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="www.w3.org/2005/Atom">
    
    <title type="text" xml:lang="en">{{ config('larablog.site_name') }}</title>
    <link type="application/atom+xml" href="{{ config('app.url') }}/feed.xml" rel="self"/>
    <link type="text" href="{{ config('app.url') }}" rel="alternate"/>
    <updated>{{ @$last->published_at }}</updated>
    <id>{{ config('app.url') }}{{ config('larablog.site_path') }}</id>
    <author>
        <name>{{ config('larablog.site_author') }}</name>
    </author>
    
    @foreach ($posts as $p)
        <entry>
            <title>{{ $p->title }}</title>
            <link href="{{ $p->url }}"/>
            <updated>{{ $p->published_at }}</updated>
            <id>{{ $p->url }}</id>
            <content type="html">{{ $p->meta->description }}</content>
        </entry>
    @endforeach
</feed>