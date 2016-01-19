<form class="hidden-xs" action="{{ route('search') }}">
	<div class="input-group">
		<input type="text" name="q" class="form-control" placeholder="Search"/>
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit">Go</button>
		</span>
    </div>
</form>

<hr/>

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