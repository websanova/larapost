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

@foreach(config('larablog.site_headers') as $header)
    @include($header);
@endforeach

<div id="container" class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
			@include ($view)
	    </div>
	    <div class="hidden-xs col-sm-4 col-md-3 col-lg-2">
	    	<br/>
		    @include ('larablog::layout.sidebar')
	    </div>
    </div>
</div>

@foreach(config('larablog.site_footers') as $site_footers)
    @include($site_footers);
@endforeach

<br/>

<div class="container">
	<hr/>

    <div class="row">
        <div class="col-xs-12">
            <div class="pull-left">
                &copy {{ date('Y') }}
            </div>

            <div class="pull-right">
                Powered by <a href="https://github.com/websanova/larablog">LaraBlog</a>
            </div>
        </div>
    </div>
</div>

<br/>

@include ('larablog::layout.footer')