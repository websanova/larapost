<form class="hidden-xs" action="{{ route('search') }}">
	<div class="input-group">
		<input type="text" name="q" class="form-control" placeholder="Search"/>
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit">Go</button>
		</span>
    </div>
</form>

<hr/>

<h4>Popular</h4>

<div clas="row">
	<div class="col-xs-12">
		<ul class="list-group text-muted">
			@foreach (\Websanova\Larablog\Larablog::top() as $t)
				<li><a href="{{ $t->url }}">{{ $t->title }}</a></li>
			@endforeach
		</ul>
	</div>
</div>