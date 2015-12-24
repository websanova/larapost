
<!doctype html>
<html class="base en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="robots" content="NOODP,NOYDIR" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <meta name="google-site-verification" content="0JyXAX-vhy2alkzysO2rJ_ZLx-ldjIN29bkyerato-Q" />

    @include ('larablog::meta')

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link type="application/opensearchdescription+xml" rel="search" title="Websanova" href="http://www.websanova.com/search.xml" />

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ config('larablog.site.name') }}</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="visible-xs">
                    <a>
                        <form action="{{ config('larablog.search.path') }}">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go</button>
                                </span>
                            </div>
                        </form>
                    </a>
                </li>

                @foreach (config('larablog.site.nav') as $key => $val) 
                    <li class="{{ ('/' . Request::path()) === $key ? 'active' : '' }}">
                        <a href="{{ $key }}">{{ $val }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<br/><br/><br/>

<div id="container" class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">

