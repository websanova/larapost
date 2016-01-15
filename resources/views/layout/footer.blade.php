@if (false)
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@else
    <script src="/lib/jquery.1.11.1.min.js"></script>
    <script src="/lib/bootstrap.3.3.5.min.js"></script>
@endif

@foreach(config('larablog.site_footers') as $site_footer)
    @include ($site_footer)
@endforeach

<body>
</html>