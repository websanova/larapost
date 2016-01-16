@foreach(config('larablog.site_footers') as $site_footer)
    @include ($site_footer)
@endforeach

<body>
</html>