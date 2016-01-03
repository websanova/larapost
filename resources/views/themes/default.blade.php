@include ('larablog::layout.header')

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ config('larablog.site_name') }}</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="visible-xs">
                    <a>
                        <form action="{{ config('larablog.search_path') }}">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go</button>
                                </span>
                            </div>
                        </form>
                    </a>
                </li>

                @foreach (config('larablog.site_pages') as $key => $val) 
                    <li class="{{ ('/' . Request::path()) === $key ? 'active' : '' }}">
                        <a href="{{ $key }}">{{ $val }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<br/><br/><br/>

@foreach(config('larablog.site_headers') as $site_header)
    @include($site_header);
@endforeach

<div id="container" class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
			@include ($view)
	    </div>
	    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
	    	<br/>
		    @include ('larablog::layout.sidebar')
	    </div>
    </div>
</div>

@foreach(config('larablog.site_footers') as $site_footer)
    @include($site_footer);
@endforeach

<br/>

<div class="container">
	<hr/>

    <div class="row">
        <div class="col-xs-12">
            <div class="pull-left">
                &copy {{ date('Y') }}

                &nbsp;

                <a href="{{ config('larablog.feed_path') }}" class="text-muted">
                    <i class="fa fa-lg fa-rss-square"></i>
                </a>

                @if (config('larablog.twitter'))
                    &nbsp;
                    <a href="https://twitter.com/{{ config('larablog.twitter') }}" class="text-muted">
                        <i class="fa fa-lg fa-twitter-square"></i>
                    </a>
                @endif

                @if (config('larablog.facebook'))
                    &nbsp;
                    <a href="https://facebook.com/{{ config('larablog.facebook') }}" class="text-muted">
                        <i class="fa fa-lg fa-facebook-square"></i>
                    </a>
                @endif
            </div>

            <div class="pull-right">
                Powered by <a href="https://github.com/websanova/larablog">LaraBlog</a>
            </div>
        </div>
    </div>
</div>

<br/>

@include ('larablog::layout.footer')