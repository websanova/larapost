<?xml version="1.0" encoding="UTF-8"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
  
    @foreach (config('larablog.site_pages') as $k => $v)
        @if (substr($k, 0, 4) !== 'http')
            <url> 
                <loc>{!! htmlspecialchars(config('app.url') . $k) !!}</loc>
                <image:image>
                    <image:loc>{!! htmlspecialchars(config('app.url') . config('larablog.site_logo')) !!}</image:loc> 
                </image:image>
                <lastmod>{!! htmlspecialchars(@$last->published_at) !!}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
        @endif
    @endforeach

    @foreach ($posts as $p)
        <url> 
            <loc>{!! htmlspecialchars($p->url) !!}</loc>
            <image:image>
                @if ($p->img)
                    <image:loc>{!! htmlspecialchars(config('app.url') . $p->meta->img) !!}</image:loc>
                @else
                    <image:loc>{!! htmlspecialchars(config('app.url') . config('larablog.site_logo')) !!}</image:loc>
                @endif
            </image:image>
            <lastmod>{!! htmlspecialchars($p->published_at) !!}</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>