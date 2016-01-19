@forelse ($posts as $k => $p)
	@if ($k > 0)
		<hr/>
	@endif

	<h1><a href="{{ $p->url }}">{{ $p->full_title }}</a></h1>

	<div class="text-muted">{{ $p->published_at->format('M d Y') }}</div>
	
	<div>
		@foreach ($p->tags as $t)
			<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
		@endforeach

		@if ($p->serie)
			<a href="{{ $p->serie->url }}" class="label label-warning">{{ $p->serie->title }}</a>
		@endif
	</div>
	<br/>

	<div>{{ $p->meta->description }}</div>
@empty
	<br/>

	No posts found.
@endforelse

@if ($posts->total() > $posts->perPage())
	<hr/>

	{!! $posts->appends(request()->all())->render() !!}
@endif