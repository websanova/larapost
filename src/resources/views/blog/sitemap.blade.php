<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
  xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
  
  @foreach (config('larablog.site_pages') as $k => $v)
    <url> 
      <loc>{{ config('app.url') }}{{ $k }}</loc>
      <image:image>
         <image:loc>{{ config('app.url') }}/img/logo-200x200.png</image:loc> 
      </image:image>
      <lastmod>{{ @$last->published_at }}</lastmod>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
    </url>
  @endforeach

  @foreach ($posts as $p)
    <url> 
      <loc>{{ config('app.url') }}{{ $p->slug }}</loc>
      <image:image>
        @if ($p->img)
          <image:loc>{{ config('app.url') }}{{ $p->img }}</image:loc>
        @else
          <image:loc>{{ config('app.url') }}/img/logo-200x200.png</image:loc>
        @endif
      </image:image>
      <lastmod>{{ $p->published_at }}</lastmod>
      <priority>1.0</priority>
    </url>
  @endforeach
</urlset>