<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
    <title>{!! config('larablog.site.name') !!}</title>
    <link>{!! htmlspecialchars(url('/')) !!}</link>
    <description>{!! htmlspecialchars(config('larablog.meta.description')) !!}</description>
    <lastBuildDate>{!! htmlspecialchars(date('c', strtotime(@$last->published_at))) !!}</lastBuildDate>
    <language>en-us</language>

    @foreach ($posts as $p)
        <item>
            <title>{!! htmlspecialchars($p->full_title) !!}</title>
            <link>{!! htmlspecialchars($p->url) !!}</link>
            <guid>{!! htmlspecialchars($p->url) !!}</guid>
            <pubDate>{!! htmlspecialchars(date('c', strtotime($p->published_at))) !!}</pubDate>
            <description>[CDATA[{!! htmlspecialchars($p->meta->description) !!}]]</description>
            <image>
            <url>{!! htmlspecialchars($p->img) !!}</url>
            </image>
        </item>
    @endforeach
</channel>
</rss>