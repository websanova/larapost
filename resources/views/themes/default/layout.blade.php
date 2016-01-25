<!doctype html>
<html class="base en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="robots" content="NOODP,NOYDIR" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    
    @section ('meta.opensearch')
        <link type="application/opensearchdescription+xml" rel="search" title="{{ config('larablog.site.name') }}" href="{{ route('opensearch') }}" />
    @show
    
    @section ('meta.title')
        <title>{{ @$title ?: (@$post->full_title ?: config('larablog.meta.title')) }}</title>
    @show

    @section ('meta.keywords')
        <meta name="keywords" content="{{ @$keywords ?: (@$post->meta->keywords ?: config('larablog.meta.keywords')) }}" />
    @show

    @section ('meta.description')
        <meta name="description" content="{{ @$description ?: (@$post->meta->description ?: config('larablog.meta.description')) }}" />
    @show

    @section ('meta.og')
        <meta property="og:title" content="{{ @$title ?: (@$post->full_title ?: config('larablog.meta.title')) }}" />
        <meta property="og:type" content="{{ @$type ?: 'article' }}" />
        <meta property="og:url" content="{{ url('/') }}{{ @$slug ?: (@$post->slug ?: '/' . Request::path()) }}" />
        <meta property="og:description" content="{{ @$description ?: (@$post->meta->description ?: config('larablog.meta.description')) }}" />
        <meta property="og:locale" content="{{ config('app.locale') }}" />
        <meta property="og:site_name" content="{{ config('larablog.site.name') }}" />
        <meta property="og:image" content="{{ url('/') }}{{ @$img ?: (@$post->meta->img ?: config('larablog.meta.logo')) }}" />
    @show

    @section ('meta.files')
        <link type="text/css" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    @show

    @section ('meta.styles')
        <style>
            .callout {padding: 20px; margin-bottom: 20px; border: 1px solid #eee; border-left-width: 5px; border-radius: 3px;}
            .callout h4 {margin-top: 0; margin-bottom: 5px;}
            .callout p:last-child {margin-bottom: 0;}
            .callout code {border-radius: 3px;}
            .callout+.callout {margin-top: -5px;}
            .callout-default {border-left-color: #777;}
            .callout-default h4 {color: #777;}
            .callout-primary {border-left-color: #428bca;}
            .callout-primary h4 {color: #428bca;}
            .callout-success {border-left-color: #5cb85c;}
            .callout-success h4 {color: #5cb85c;}
            .callout-danger {border-left-color: #d9534f;}
            .callout-danger h4 {color: #d9534f;}
            .callout-warning {border-left-color: #f0ad4e;}
            .callout-warning h4 {color: #f0ad4e;}
            .callout-info {border-left-color: #1b809e;}
            .callout-info h4 {color: #1b809e;}
        </style>
    @show
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
                <a class="navbar-brand" href="{{ route('blog') }}">{{ config('larablog.nav.title') }}</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="visible-xs">
                        <a>
                            @include (lb_view('components.search'))
                        </a>
                    </li>

                    @foreach (config('larablog.nav.links') as $k => $v) 
                        <li class="{{ Request::path() === $v ? 'active' : '' }}">
                            <a href="{{ $v }}">{{ $k }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <br/><br/><br/>

    <div id="container" class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                @section ('layout.view')
                    @include ($view)
                @show
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <br/>
                <div class="hidden-xs">
                    @include (lb_view('.components.search'))
                </div>

                <hr/>

                @section ('sidebar.series')
                    @if ( ! $series->isEmpty())
                        <h4>Series</h4>

                        <div clas="row">
                            <div class="col-xs-12">
                                <ul class="list-group text-muted">
                                    @foreach ($series as $s)
                                        <li><a href="{{ $s->url }}">{{ $s->title }} ({{ $s->posts_count}} Parts)</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @show

                @section ('sidebar.popular')
                    @if ( ! $top->isEmpty())
                        <h4>Popular</h4>

                        <div clas="row">
                            <div class="col-xs-12">
                                <ul class="list-group text-muted">
                                    @foreach ($top as $t)
                                        <li><a href="{{ $t->url }}">{{ $t->full_title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @show
            </div>
        </div>
    </div>

    <div class="container">
        <hr/>

        <div class="row">
            <div class="col-xs-12">
                @section ('footer-nav.left')
                    <div class="pull-left">
                        @if (config('larablog.footer.copy'))
                            {{ config('larablog.site.name') }}
                            &copy {{ date('Y') }}
                            &nbsp;
                        @endif
                    </div>
                @show

                @section ('footer-nav.right')
                    <div class="pull-right text-right">
                        <a href="{{ route('feed') }}">
                            <i class="fa fa-2x fa-rss-square"></i></a>

                        @if (config('larablog.social.twitter'))
                            &nbsp;
                            <a href="https://twitter.com/{{ config('larablog.social.twitter') }}">
                                <i class="fa fa-2x fa-twitter-square"></i></a>
                        @endif

                        @if (config('larablog.social.facebook'))
                            &nbsp;
                            <a href="https://facebook.com/{{ config('larablog.social.facebook') }}">
                                <i class="fa fa-2x fa-facebook-square"></i></a>
                        @endif

                        @if (config('larablog.footer.plug'))
                            <h6 class="text-muted">Powered by <a href="https://github.com/websanova/larablog">LaraBlog</a></h6>
                        @endif
                    </div>
                @show
            </div>
        </div>
    </div>

    <br/>

    @yield ('layout.end')
<body>
</html>