<?xml version="1.0" encoding="UTF-8"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">

    <url>
        <loc>{!! htmlspecialchars(route('feed')) !!}</loc>
        <image:image>
            <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
        </image:image>
        <lastmod>{!! htmlspecialchars(date('c', strtotime(@$last->published_at))) !!}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{!! htmlspecialchars(route('tags')) !!}</loc>
        <image:image>
            <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
        </image:image>
        <lastmod>{!! htmlspecialchars(date('c', strtotime(@$last->published_at))) !!}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{!! htmlspecialchars(route('series')) !!}</loc>
        <image:image>
            <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
        </image:image>
        <lastmod>{!! htmlspecialchars(date('c', strtotime(@$last->published_at))) !!}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    @foreach ($series as $s)
        <url>
            <loc>{!! htmlspecialchars($s->url) !!}</loc>
            <image:image>
                <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
            </image:image>
            <lastmod>{!! htmlspecialchars(date('c', strtotime($s->updated_at))) !!}</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach

    @foreach ($tags as $t)
        <url>
            <loc>{!! htmlspecialchars($t->url) !!}</loc>
            <image:image>
                <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
            </image:image>
            <lastmod>{!! htmlspecialchars(date('c', strtotime($t->updated_at))) !!}</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach

    @foreach ($pages as $p)
        <url>
            <loc>{!! htmlspecialchars($p->url) !!}</loc>
            <image:image>
                @if ($p->img)
                    <image:loc>{!! htmlspecialchars(url('/') . $p->meta->img) !!}</image:loc>
                @else
                    <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
                @endif
            </image:image>
            <lastmod>{!! htmlspecialchars(date('c', strtotime($p->updated_at))) !!}</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach

    @foreach ($posts as $p)
        <url>
            <loc>{!! htmlspecialchars($p->url) !!}</loc>
            <image:image>
                @if ($p->img)
                    <image:loc>{!! htmlspecialchars(url('/') . $p->meta->img) !!}</image:loc>
                @else
                    <image:loc>{!! htmlspecialchars(url('/') . config('larablog.meta.logo')) !!}</image:loc>
                @endif
            </image:image>
            <lastmod>{!! htmlspecialchars(date('c', strtotime($p->published_at))) !!}</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>