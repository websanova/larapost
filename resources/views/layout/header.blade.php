
<!doctype html>
<html class="base en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="robots" content="NOODP,NOYDIR" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    
    <link type="application/opensearchdescription+xml" rel="search" title="{{ config('larablog.site_name') }}" href="{{ config('app.url') . config('larablog.opensearch_path') }" />
    
    @include ('larablog::layout.meta')

    <link type="text/css" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>

@foreach(config('larablog.site_headers') as $site_header)
    @include ($site_header)
@endforeach