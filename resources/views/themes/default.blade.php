@include ('larablog::layout.header')

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
                        <form action="{{ route('search') }}">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go</button>
                                </span>
                            </div>
                        </form>
                    </a>
                </li>

                @foreach (config('larablog.nav.links') as $k => $v) 
                    <li class="{{ Request::url() === route($k) ? 'active' : '' }}">
                        <a href="{{ route($k) }}">{{ $v }}</a>
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
			@include ($view)
	    </div>
	    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
	    	<br/>
		    @include ('larablog::layout.sidebar')
	    </div>
    </div>
</div>

<br/>

<div class="container">
	<hr/>

    <div class="row">
        <div class="col-xs-12">
            <div class="pull-left">
                @if (config('larablog.footer.copy'))
                    &copy {{ date('Y') }}
                    &nbsp;
                @endif

                <a href="{{ route('feed') }}" class="text-muted">
                    <i class="fa fa-lg fa-rss-square"></i>
                </a>

                @if (config('larablog.social.twitter'))
                    &nbsp;
                    <a href="https://twitter.com/{{ config('larablog.social.twitter') }}" class="text-muted">
                        <i class="fa fa-lg fa-twitter-square"></i>
                    </a>
                @endif

                @if (config('larablog.social.facebook'))
                    &nbsp;
                    <a href="https://facebook.com/{{ config('larablog.social.facebook') }}" class="text-muted">
                        <i class="fa fa-lg fa-facebook-square"></i>
                    </a>
                @endif
            </div>

            <div class="pull-right">
                @if (config('larablog.footer.plug'))
                    Powered by <a href="https://github.com/websanova/larablog">LaraBlog</a>
                @endif
            </div>
        </div>
    </div>
</div>

<br/>

@include ('larablog::layout.footer')